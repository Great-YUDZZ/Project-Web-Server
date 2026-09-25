import bpy
import os
import math
from PIL import Image

def srgb_to_linear(c):
    if c <= 0.04045:
        return c / 12.92
    else:
        return ((c + 0.055) / 1.055) ** 2.4

def hex_to_linear(hex_str):
    hex_str = hex_str.lstrip('#')
    r = int(hex_str[0:2], 16) / 255.0
    g = int(hex_str[2:4], 16) / 255.0
    b = int(hex_str[4:6], 16) / 255.0
    return (srgb_to_linear(r), srgb_to_linear(g), srgb_to_linear(b), 1.0)

def clear_scene():
    bpy.ops.wm.read_factory_settings(use_empty=True)

def setup_camera_and_lights(scene, cam_loc=(3.2, -4.2, 2.8), look_at=(0, 0, 0), lens=65):
    # Camera
    cam_data = bpy.data.cameras.new('Camera')
    cam_data.lens = lens
    cam_obj = bpy.data.objects.new('Camera', cam_data)
    scene.collection.objects.link(cam_obj)
    scene.camera = cam_obj
    cam_obj.location = cam_loc
    
    # Track to target
    target = bpy.data.objects.new('CamTarget', None)
    target.location = look_at
    scene.collection.objects.link(target)
    
    track = cam_obj.constraints.new(type='TRACK_TO')
    track.target = target
    track.track_axis = 'TRACK_NEGATIVE_Z'
    track.up_axis = 'UP_Y'
    
    # 1. Key Light (Main soft white-cyan studio light)
    l1 = bpy.data.objects.new('KeyLight', bpy.data.lights.new('KeyLight', 'POINT'))
    l1.data.energy = 550
    l1.data.shadow_soft_size = 0.4
    l1.data.color = (0.95, 0.98, 1.0)
    l1.location = (4.0, -3.5, 4.5)
    scene.collection.objects.link(l1)
    
    # 2. Discord Blurple Fill Light (Soft ambiance)
    l2 = bpy.data.objects.new('BlurpleFill', bpy.data.lights.new('BlurpleFill', 'POINT'))
    l2.data.energy = 220
    l2.data.shadow_soft_size = 0.6
    l2.data.color = hex_to_linear('#5865F2')[:3]
    l2.location = (-3.5, -4.0, 1.5)
    scene.collection.objects.link(l2)
    
    # 3. Cyber Cyan Rim Light (Sharp edge pop from behind)
    l3 = bpy.data.objects.new('CyanRim', bpy.data.lights.new('CyanRim', 'POINT'))
    l3.data.energy = 750
    l3.data.shadow_soft_size = 0.2
    l3.data.color = hex_to_linear('#00F0FF')[:3]
    l3.location = (-4.0, 3.5, 3.0)
    scene.collection.objects.link(l3)
    
    # 4. Magenta / Violet Accent Rim (Discord playful depth)
    l4 = bpy.data.objects.new('VioletRim', bpy.data.lights.new('VioletRim', 'POINT'))
    l4.data.energy = 450
    l4.data.shadow_soft_size = 0.3
    l4.data.color = hex_to_linear('#EB459E')[:3]
    l4.location = (2.5, 4.0, -1.0)
    scene.collection.objects.link(l4)

    # 5. Top Highlight Light
    l5 = bpy.data.objects.new('TopGleam', bpy.data.lights.new('TopGleam', 'POINT'))
    l5.data.energy = 300
    l5.data.color = (1.0, 1.0, 1.0)
    l5.location = (0, 0, 5.0)
    scene.collection.objects.link(l5)

def create_gold_material(name='GoldMat'):
    mat = bpy.data.materials.new(name=name)
    mat.use_nodes = True
    p = mat.node_tree.nodes.get('Principled BSDF')
    p.inputs['Base Color'].default_value = (1.0, 0.76, 0.15, 1.0)
    p.inputs['Metallic'].default_value = 1.0
    p.inputs['Roughness'].default_value = 0.15
    return mat

def create_crystal_glass_material(name='CrystalMat', tint_hex='#E0F2FE'):
    mat = bpy.data.materials.new(name=name)
    mat.use_nodes = True
    p = mat.node_tree.nodes.get('Principled BSDF')
    r, g, b, _ = hex_to_linear(tint_hex)
    p.inputs['Base Color'].default_value = (r, g, b, 1.0)
    p.inputs['Roughness'].default_value = 0.08
    p.inputs['Transmission Weight'].default_value = 0.92
    p.inputs['IOR'].default_value = 1.48
    return mat

def create_emission_material(name='NeonMat', hex_code='#57F287', strength=8.0):
    mat = bpy.data.materials.new(name=name)
    mat.use_nodes = True
    mat.node_tree.nodes.clear()
    em = mat.node_tree.nodes.new('ShaderNodeEmission')
    em.inputs['Color'].default_value = hex_to_linear(hex_code)
    em.inputs['Strength'].default_value = strength
    out = mat.node_tree.nodes.new('ShaderNodeOutputMaterial')
    mat.node_tree.links.new(em.outputs['Emission'], out.inputs['Surface'])
    return mat

def create_matte_clay_material(name='ClayMat', hex_code='#1E1F29', roughness=0.35, metallic=0.05):
    mat = bpy.data.materials.new(name=name)
    mat.use_nodes = True
    p = mat.node_tree.nodes.get('Principled BSDF')
    p.inputs['Base Color'].default_value = hex_to_linear(hex_code)
    p.inputs['Roughness'].default_value = roughness
    p.inputs['Metallic'].default_value = metallic
    p.inputs['Coat Weight'].default_value = 0.4
    p.inputs['Coat Roughness'].default_value = 0.15
    return mat

# ==========================================
# 1. MODEL: DISCORD-STYLE 3D RJ-45 CONNECTOR
# ==========================================
def build_rj45_connector():
    # Base clear crystal body
    bpy.ops.mesh.primitive_cube_add(size=1.0, location=(0, 0, 0))
    body = bpy.context.active_object
    body.scale = (0.75, 1.3, 0.65)
    bpy.ops.object.transform_apply(scale=True)
    
    # Bevel modifier for rounded Discord look
    bev = body.modifiers.new(name='Bevel', type='BEVEL')
    bev.width = 0.08
    bev.segments = 4
    bpy.ops.object.shade_smooth()
    body.data.materials.append(create_crystal_glass_material('RJ45BodyMat', '#DDF2FD'))
    
    # Gold Contact Pins (8 pins)
    gold_mat = create_gold_material('PinGold')
    for i in range(8):
        x_pos = -0.52 + (i * 0.15)
        bpy.ops.mesh.primitive_cube_add(size=0.1, location=(x_pos, 1.15, 0.42))
        pin = bpy.context.active_object
        pin.scale = (0.35, 1.8, 0.4)
        bpy.ops.object.transform_apply(scale=True)
        bpy.ops.object.shade_smooth()
        pin.data.materials.append(gold_mat)
        
    # Snap Clip (Snagless latch on top in Discord Blurple)
    bpy.ops.mesh.primitive_cube_add(size=1.0, location=(0, -0.1, 0.85))
    clip = bpy.context.active_object
    clip.scale = (0.28, 1.05, 0.12)
    clip.rotation_euler = (math.radians(18), 0, 0)
    bpy.ops.object.transform_apply(scale=True, rotation=True)
    bev_clip = clip.modifiers.new(name='Bevel', type='BEVEL')
    bev_clip.width = 0.05
    bev_clip.segments = 3
    bpy.ops.object.shade_smooth()
    clip.data.materials.append(create_matte_clay_material('ClipMat', '#5865F2', roughness=0.2))
    
    # Cable Boot (Tactile rubber collar in deep dark matte)
    bpy.ops.mesh.primitive_cylinder_add(radius=0.42, depth=0.7, vertices=32, location=(0, -1.4, 0))
    boot = bpy.context.active_object
    boot.rotation_euler = (math.radians(90), 0, 0)
    bpy.ops.object.transform_apply(rotation=True)
    bpy.ops.object.shade_smooth()
    boot.data.materials.append(create_matte_clay_material('BootMat', '#2B2D31', roughness=0.4))
    
    # Flexible Curving Cable (Braided Ethernet Cable trailing backwards)
    bpy.ops.curve.primitive_bezier_curve_add(location=(0, -1.7, 0))
    curve = bpy.context.active_object
    curve.data.bevel_depth = 0.32
    curve.data.bevel_resolution = 8
    curve.data.use_fill_caps = True
    
    # Shape the curve into an S-swirl
    bp0 = curve.data.splines[0].bezier_points[0]
    bp1 = curve.data.splines[0].bezier_points[1]
    bp0.co = (0, -1.7, 0)
    bp0.handle_right = (0, -2.5, -0.2)
    bp1.co = (-1.2, -3.5, -0.8)
    bp1.handle_left = (-0.6, -2.8, -0.5)
    
    curve.data.materials.append(create_matte_clay_material('CableMat', '#00F0FF', roughness=0.25))
    
    # Glowing internal data core / LED pulse
    bpy.ops.mesh.primitive_uv_sphere_add(radius=0.18, segments=32, ring_count=16, location=(0, 0.3, 0.05))
    pulse = bpy.context.active_object
    pulse.data.materials.append(create_emission_material('DataGlow', '#57F287', strength=12.0))
    
    # Floating ambient orbital ring (Discord playful particle)
    bpy.ops.mesh.primitive_torus_add(major_radius=1.35, minor_radius=0.035, location=(0, 0.2, 0.2))
    ring = bpy.context.active_object
    ring.rotation_euler = (math.radians(35), math.radians(25), math.radians(45))
    bpy.ops.object.shade_smooth()
    ring.data.materials.append(create_emission_material('RingGlow', '#5865F2', strength=6.0))

# ===============================================
# 2. MODEL: DISCORD-STYLE 3D CYBER SECURITY SHIELD
# ===============================================
def build_cyber_shield():
    # Shield Body (Tapered hexagonal cyber shield)
    bpy.ops.mesh.primitive_cylinder_add(vertices=6, radius=1.35, depth=0.35, location=(0, 0, 0))
    shield = bpy.context.active_object
    shield.scale = (0.95, 0.7, 1.35)
    shield.rotation_euler = (math.radians(90), 0, math.radians(30))
    bpy.ops.object.transform_apply(scale=True, rotation=True)
    
    bev = shield.modifiers.new(name='Bevel', type='BEVEL')
    bev.width = 0.12
    bev.segments = 4
    bpy.ops.object.shade_smooth()
    shield.data.materials.append(create_matte_clay_material('ShieldBase', '#1E1F22', roughness=0.28))
    
    # Inner Beveled Shield Plate (Vibrant Blurple)
    bpy.ops.mesh.primitive_cylinder_add(vertices=6, radius=1.1, depth=0.25, location=(0, -0.15, 0))
    inner = bpy.context.active_object
    inner.scale = (0.92, 0.68, 1.3)
    inner.rotation_euler = (math.radians(90), 0, math.radians(30))
    bpy.ops.object.transform_apply(scale=True, rotation=True)
    inner.data.materials.append(create_matte_clay_material('InnerShield', '#5865F2', roughness=0.18))
    
    # Glowing Circuit Inset Border
    bpy.ops.mesh.primitive_torus_add(major_radius=1.18, minor_radius=0.04, location=(0, -0.22, 0))
    neon_border = bpy.context.active_object
    neon_border.scale = (0.9, 1.25, 0.5)
    neon_border.rotation_euler = (math.radians(90), 0, 0)
    bpy.ops.object.shade_smooth()
    neon_border.data.materials.append(create_emission_material('ShieldNeon', '#00F0FF', strength=8.0))
    
    # Center 3D Padlock: Lock Body (Tactile Gold with soft bevel)
    bpy.ops.mesh.primitive_cube_add(size=0.65, location=(0, -0.45, -0.12))
    lock_body = bpy.context.active_object
    lock_body.scale = (1.0, 0.45, 0.9)
    bpy.ops.object.transform_apply(scale=True)
    bev_l = lock_body.modifiers.new(name='Bevel', type='BEVEL')
    bev_l.width = 0.08
    bev_l.segments = 4
    bpy.ops.object.shade_smooth()
    lock_body.data.materials.append(create_gold_material('PadlockGold'))
    
    # Padlock Shackle (Chrome / Silver Curved Torus)
    bpy.ops.mesh.primitive_torus_add(major_radius=0.28, minor_radius=0.085, location=(0, -0.45, 0.28))
    shackle = bpy.context.active_object
    shackle.rotation_euler = (math.radians(90), 0, 0)
    bpy.ops.object.shade_smooth()
    s_mat = bpy.data.materials.new(name='ShackleChrome')
    s_mat.use_nodes = True
    sp = s_mat.node_tree.nodes.get('Principled BSDF')
    sp.inputs['Base Color'].default_value = (0.95, 0.95, 0.98, 1.0)
    sp.inputs['Metallic'].default_value = 0.98
    sp.inputs['Roughness'].default_value = 0.08
    shackle.data.materials.append(s_mat)
    
    # Glowing Keyhole in the center of the padlock
    bpy.ops.mesh.primitive_cylinder_add(radius=0.09, depth=0.15, location=(0, -0.62, -0.08))
    keyhole = bpy.context.active_object
    keyhole.rotation_euler = (math.radians(90), 0, 0)
    keyhole.data.materials.append(create_emission_material('KeyGlow', '#57F287', strength=10.0))
    
    # 2 Floating Orbital Sparkles / Data Nodes
    bpy.ops.mesh.primitive_uv_sphere_add(radius=0.12, location=(-1.3, -0.2, 0.85))
    s1 = bpy.context.active_object
    s1.data.materials.append(create_emission_material('Spark1', '#57F287', strength=9.0))
    
    bpy.ops.mesh.primitive_uv_sphere_add(radius=0.16, location=(1.35, -0.3, -0.75))
    s2 = bpy.context.active_object
    s2.data.materials.append(create_emission_material('Spark2', '#EB459E', strength=9.0))

# ==============================================
# 3. MODEL: DISCORD-STYLE 3D CORE SWITCH & SERVER
# ==============================================
def build_server_switch():
    # Main Switch Chassis: Sleek matte rounded tech block
    bpy.ops.mesh.primitive_cube_add(size=1.0, location=(0, 0, 0))
    chassis = bpy.context.active_object
    chassis.scale = (2.2, 1.5, 0.75)
    bpy.ops.object.transform_apply(scale=True)
    bev = chassis.modifiers.new(name='Bevel', type='BEVEL')
    bev.width = 0.1
    bev.segments = 4
    bpy.ops.object.shade_smooth()
    chassis.data.materials.append(create_matte_clay_material('ChassisMat', '#1E1F22', roughness=0.3))
    
    # Top Accent Glass Panel / OLED Status Screen
    bpy.ops.mesh.primitive_cube_add(size=1.0, location=(0, -0.1, 0.39))
    screen = bpy.context.active_object
    screen.scale = (1.9, 1.1, 0.05)
    bpy.ops.object.transform_apply(scale=True)
    bpy.ops.object.shade_smooth()
    screen.data.materials.append(create_crystal_glass_material('ScreenGlass', '#0284C7'))
    
    # Front Bezel (Indented port bay)
    bpy.ops.mesh.primitive_cube_add(size=1.0, location=(0, -1.46, 0))
    bezel = bpy.context.active_object
    bezel.scale = (1.95, 0.15, 0.5)
    bpy.ops.object.transform_apply(scale=True)
    bezel.data.materials.append(create_matte_clay_material('BezelMat', '#2B2D31', roughness=0.25))
    
    # Dual Row of RJ45 Ports (8 ports total: 4 top, 4 bottom)
    port_mat = create_matte_clay_material('PortHole', '#111214', roughness=0.6)
    led_green = create_emission_material('LedGreen', '#57F287', strength=8.0)
    led_cyan = create_emission_material('LedCyan', '#00F0FF', strength=8.0)
    led_amber = create_emission_material('LedAmber', '#FEE75C', strength=8.0)
    
    led_colors = [led_green, led_cyan, led_green, led_cyan]
    
    for i in range(4):
        x_pos = -1.2 + (i * 0.8)
        # Port socket
        bpy.ops.mesh.primitive_cube_add(size=0.32, location=(x_pos, -1.5, -0.05))
        port = bpy.context.active_object
        port.scale = (1.0, 0.25, 0.85)
        bpy.ops.object.transform_apply(scale=True)
        port.data.materials.append(port_mat)
        
        # Link Activity LED
        bpy.ops.mesh.primitive_uv_sphere_add(radius=0.06, segments=16, ring_count=8, location=(x_pos, -1.53, 0.16))
        led = bpy.context.active_object
        led.data.materials.append(led_colors[i])
        
    # Central Glowing Network Node Ring on top of the server
    bpy.ops.mesh.primitive_torus_add(major_radius=0.45, minor_radius=0.045, location=(0, -0.1, 0.44))
    node_ring = bpy.context.active_object
    bpy.ops.object.shade_smooth()
    node_ring.data.materials.append(create_emission_material('TopHalo', '#5865F2', strength=7.0))
    
    # 3 Floating Cloud / Network Satellites around the switch
    bpy.ops.mesh.primitive_uv_sphere_add(radius=0.18, location=(-1.8, -0.8, 0.85))
    s1 = bpy.context.active_object
    s1.data.materials.append(create_emission_material('Sat1', '#57F287', strength=8.0))
    
    bpy.ops.mesh.primitive_uv_sphere_add(radius=0.22, location=(1.9, 0.5, 0.7))
    s2 = bpy.context.active_object
    s2.data.materials.append(create_emission_material('Sat2', '#00F0FF', strength=8.0))

def render_all_assets():
    out_dir = '/var/www/project_tkj_yuda2/public/images/discord_assets'
    os.makedirs(out_dir, exist_ok=True)
    
    assets = [
        {
            'name': 'RJ-45 Crystal Jack & Cable',
            'builder': build_rj45_connector,
            'cam_loc': (3.6, -4.0, 3.2),
            'look_at': (0, -0.4, 0.1),
            'png': os.path.join(out_dir, 'rj45_discord_3d.png'),
            'webp': os.path.join(out_dir, 'rj45_discord_3d.webp')
        },
        {
            'name': 'Cyber Security Shield & Key',
            'builder': build_cyber_shield,
            'cam_loc': (3.4, -4.2, 2.5),
            'look_at': (0, 0, 0),
            'png': os.path.join(out_dir, 'cyber_shield_discord_3d.png'),
            'webp': os.path.join(out_dir, 'cyber_shield_discord_3d.webp')
        },
        {
            'name': 'Core Switch & Cloud Server',
            'builder': build_server_switch,
            'cam_loc': (3.8, -4.5, 3.6),
            'look_at': (0, -0.3, 0.1),
            'png': os.path.join(out_dir, 'core_switch_discord_3d.png'),
            'webp': os.path.join(out_dir, 'core_switch_discord_3d.webp')
        }
    ]
    
    for item in assets:
        print(f"=== Rendering Discord 3D Asset: {item['name']} ===")
        clear_scene()
        scene = bpy.context.scene
        scene.render.engine = 'CYCLES'
        scene.cycles.use_denoising = False
        scene.cycles.samples = 64
        scene.render.film_transparent = True
        scene.render.resolution_x = 512
        scene.render.resolution_y = 512
        scene.render.filepath = item['png']
        scene.view_settings.view_transform = 'Standard'
        
        # Studio world
        world = bpy.data.worlds.new('StudioWorld')
        world.use_nodes = True
        bg = world.node_tree.nodes.get('Background')
        bg.inputs['Color'].default_value = (0.02, 0.02, 0.04, 1.0)
        bg.inputs['Strength'].default_value = 0.05
        scene.world = world
        
        # Camera & Lights
        setup_camera_and_lights(scene, cam_loc=item['cam_loc'], look_at=item['look_at'])
        
        # Build the 3D model
        item['builder']()
        
        # Render
        bpy.ops.render.render(write_still=True)
        print(f"Rendered: {item['png']}")
        
        # Convert to WebP
        if os.path.exists(item['png']):
            img = Image.open(item['png'])
            img.save(item['webp'], 'WEBP', quality=95)
            print(f"Saved WebP: {item['webp']}")

if __name__ == '__main__':
    render_all_assets()
