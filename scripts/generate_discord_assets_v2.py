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

def setup_camera_and_lights(scene, cam_loc=(3.4, -4.2, 2.8), look_at=(0, 0, 0), lens=60):
    # Camera
    cam_data = bpy.data.cameras.new('Camera')
    cam_data.lens = lens
    cam_obj = bpy.data.objects.new('Camera', cam_data)
    scene.collection.objects.link(cam_obj)
    scene.camera = cam_obj
    cam_obj.location = cam_loc
    
    target = bpy.data.objects.new('CamTarget', None)
    target.location = look_at
    scene.collection.objects.link(target)
    
    track = cam_obj.constraints.new(type='TRACK_TO')
    track.target = target
    track.track_axis = 'TRACK_NEGATIVE_Z'
    track.up_axis = 'UP_Y'
    
    # Key Light (Crisp Warm-White Key)
    l1 = bpy.data.objects.new('KeyLight', bpy.data.lights.new('KeyLight', 'POINT'))
    l1.data.energy = 550
    l1.data.shadow_soft_size = 0.3
    l1.data.color = (1.0, 0.98, 0.95)
    l1.location = (4.0, -3.5, 4.0)
    scene.collection.objects.link(l1)
    
    # Fill Light (Discord Blurple Ambience)
    l2 = bpy.data.objects.new('BlurpleFill', bpy.data.lights.new('BlurpleFill', 'POINT'))
    l2.data.energy = 260
    l2.data.shadow_soft_size = 0.5
    l2.data.color = hex_to_linear('#5865F2')[:3]
    l2.location = (-4.0, -3.0, 1.8)
    scene.collection.objects.link(l2)
    
    # Sharp Cyber Cyan Rim Light (Left-Back)
    l3 = bpy.data.objects.new('CyanRim', bpy.data.lights.new('CyanRim', 'POINT'))
    l3.data.energy = 800
    l3.data.shadow_soft_size = 0.15
    l3.data.color = hex_to_linear('#00F0FF')[:3]
    l3.location = (-3.5, 3.8, 3.2)
    scene.collection.objects.link(l3)
    
    # Warm Pink/Violet Rim Light (Right-Back)
    l4 = bpy.data.objects.new('VioletRim', bpy.data.lights.new('VioletRim', 'POINT'))
    l4.data.energy = 500
    l4.data.shadow_soft_size = 0.25
    l4.data.color = hex_to_linear('#EB459E')[:3]
    l4.location = (3.5, 3.5, 1.0)
    scene.collection.objects.link(l4)

    # Top Light
    l5 = bpy.data.objects.new('TopLight', bpy.data.lights.new('TopLight', 'POINT'))
    l5.data.energy = 220
    l5.data.color = (1.0, 1.0, 1.0)
    l5.location = (0, 0, 4.5)
    scene.collection.objects.link(l5)

def create_gold_material(name='GoldMat'):
    mat = bpy.data.materials.new(name=name)
    mat.use_nodes = True
    p = mat.node_tree.nodes.get('Principled BSDF')
    p.inputs['Base Color'].default_value = (1.0, 0.78, 0.18, 1.0)
    p.inputs['Metallic'].default_value = 1.0
    p.inputs['Roughness'].default_value = 0.14
    return mat

def create_chrome_material(name='ChromeMat'):
    mat = bpy.data.materials.new(name=name)
    mat.use_nodes = True
    p = mat.node_tree.nodes.get('Principled BSDF')
    p.inputs['Base Color'].default_value = (0.95, 0.96, 0.98, 1.0)
    p.inputs['Metallic'].default_value = 1.0
    p.inputs['Roughness'].default_value = 0.08
    return mat

def create_crystal_glass_material(name='CrystalMat', tint_hex='#DCEEFE', transmission=0.88, roughness=0.06):
    mat = bpy.data.materials.new(name=name)
    mat.use_nodes = True
    p = mat.node_tree.nodes.get('Principled BSDF')
    r, g, b, _ = hex_to_linear(tint_hex)
    p.inputs['Base Color'].default_value = (r, g, b, 1.0)
    p.inputs['Roughness'].default_value = roughness
    p.inputs['Transmission Weight'].default_value = transmission
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

def create_matte_clay_material(name='ClayMat', hex_code='#1E1F29', roughness=0.32, metallic=0.04):
    mat = bpy.data.materials.new(name=name)
    mat.use_nodes = True
    p = mat.node_tree.nodes.get('Principled BSDF')
    p.inputs['Base Color'].default_value = hex_to_linear(hex_code)
    p.inputs['Roughness'].default_value = roughness
    p.inputs['Metallic'].default_value = metallic
    p.inputs['Coat Weight'].default_value = 0.5
    p.inputs['Coat Roughness'].default_value = 0.12
    return mat

# ==========================================
# 1. MODEL: DISCORD-STYLE 3D RJ-45 CONNECTOR
# ==========================================
def build_rj45_connector():
    # Clear Crystal Jack Body
    bpy.ops.mesh.primitive_cube_add(size=1.0, location=(0, 0, 0))
    body = bpy.context.active_object
    body.scale = (1.0, 1.4, 0.75)
    bpy.ops.object.transform_apply(scale=True)
    bev = body.modifiers.new(name='Bevel', type='BEVEL')
    bev.width = 0.08
    bev.segments = 4
    bpy.ops.object.shade_smooth()
    body.data.materials.append(create_crystal_glass_material('RJ45BodyMat', '#E0F2FE', transmission=0.92, roughness=0.04))
    
    # 8 Gold Contact Pins inside the front lip (Facing positive Y)
    gold_mat = create_gold_material('PinGold')
    for i in range(8):
        x_pos = -0.38 + (i * 0.11)
        bpy.ops.mesh.primitive_cube_add(size=0.1, location=(x_pos, 0.62, 0.22))
        pin = bpy.context.active_object
        pin.scale = (0.45, 1.4, 0.4)
        bpy.ops.object.transform_apply(scale=True)
        bpy.ops.object.shade_smooth()
        pin.data.materials.append(gold_mat)
        
    # Snap Clip (Snagless latch on top attached securely in Discord Blurple)
    bpy.ops.mesh.primitive_cube_add(size=1.0, location=(0, -0.05, 0.46))
    clip = bpy.context.active_object
    clip.scale = (0.35, 1.1, 0.1)
    clip.rotation_euler = (math.radians(-12), 0, 0)
    bpy.ops.object.transform_apply(scale=True, rotation=True)
    bev_clip = clip.modifiers.new(name='Bevel', type='BEVEL')
    bev_clip.width = 0.04
    bev_clip.segments = 3
    bpy.ops.object.shade_smooth()
    clip.data.materials.append(create_matte_clay_material('ClipMat', '#5865F2', roughness=0.22))
    
    # Rear Cable Boot / Collar (Negative Y)
    bpy.ops.mesh.primitive_cylinder_add(radius=0.48, depth=0.6, vertices=32, location=(0, -0.9, 0))
    boot = bpy.context.active_object
    boot.rotation_euler = (math.radians(90), 0, 0)
    bpy.ops.object.transform_apply(rotation=True)
    bev_b = boot.modifiers.new(name='Bevel', type='BEVEL')
    bev_b.width = 0.06
    bev_b.segments = 3
    bpy.ops.object.shade_smooth()
    boot.data.materials.append(create_matte_clay_material('BootMat', '#2B2D31', roughness=0.35))
    
    # Curving Cyber Cyan Ethernet Cable leading backwards
    bpy.ops.curve.primitive_bezier_curve_add(location=(0, -1.2, 0))
    curve = bpy.context.active_object
    curve.data.bevel_depth = 0.28
    curve.data.bevel_resolution = 12
    curve.data.use_fill_caps = True
    
    bp0 = curve.data.splines[0].bezier_points[0]
    bp1 = curve.data.splines[0].bezier_points[1]
    bp0.co = (0, -1.2, 0)
    bp0.handle_right = (0, -1.8, -0.2)
    bp1.co = (0.7, -2.6, -0.6)
    bp1.handle_left = (0.3, -2.1, -0.3)
    curve.data.materials.append(create_matte_clay_material('CableMat', '#00F0FF', roughness=0.25))
    
    # Internal glowing data core pulse
    bpy.ops.mesh.primitive_uv_sphere_add(radius=0.22, segments=32, ring_count=16, location=(0, 0.1, 0.0))
    pulse = bpy.context.active_object
    pulse.data.materials.append(create_emission_material('DataGlow', '#57F287', strength=9.0))
    
    # Floating Orbital Halo Ring
    bpy.ops.mesh.primitive_torus_add(major_radius=1.3, minor_radius=0.035, location=(0, 0, 0.05))
    ring = bpy.context.active_object
    ring.rotation_euler = (math.radians(35), math.radians(20), math.radians(40))
    bpy.ops.object.shade_smooth()
    ring.data.materials.append(create_emission_material('RingGlow', '#5865F2', strength=5.0))
    
    # Orbiting Mint Green Data Sparkle
    bpy.ops.mesh.primitive_uv_sphere_add(radius=0.12, location=(1.1, 0.6, 0.6))
    sparkle = bpy.context.active_object
    sparkle.data.materials.append(create_emission_material('Sparkle', '#57F287', strength=8.0))

# ===============================================
# 2. MODEL: DISCORD-STYLE 3D CYBER SECURITY SHIELD
# ===============================================
def build_cyber_shield():
    # Outer Shield Frame (Tactile Dark Graphite)
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
    
    # Inner Front Shield Plate (Vibrant Discord Blurple)
    bpy.ops.mesh.primitive_cylinder_add(vertices=6, radius=1.12, depth=0.22, location=(0, -0.12, 0))
    inner = bpy.context.active_object
    inner.scale = (0.92, 0.68, 1.3)
    inner.rotation_euler = (math.radians(90), 0, math.radians(30))
    bpy.ops.object.transform_apply(scale=True, rotation=True)
    bev_i = inner.modifiers.new(name='Bevel', type='BEVEL')
    bev_i.width = 0.06
    bev_i.segments = 3
    bpy.ops.object.shade_smooth()
    inner.data.materials.append(create_matte_clay_material('InnerShield', '#5865F2', roughness=0.2))
    
    # Padlock Base (Luminous Gold Body)
    bpy.ops.mesh.primitive_cube_add(size=0.6, location=(0, -0.32, -0.15))
    lock_body = bpy.context.active_object
    lock_body.scale = (0.95, 0.35, 0.8)
    bpy.ops.object.transform_apply(scale=True)
    bev_l = lock_body.modifiers.new(name='Bevel', type='BEVEL')
    bev_l.width = 0.08
    bev_l.segments = 4
    bpy.ops.object.shade_smooth()
    lock_body.data.materials.append(create_gold_material('PadlockGold'))
    
    # Chrome Shackle (Polished U-bar)
    bpy.ops.mesh.primitive_torus_add(major_radius=0.24, minor_radius=0.075, location=(0, -0.32, 0.22))
    shackle = bpy.context.active_object
    shackle.rotation_euler = (math.radians(90), 0, 0)
    bpy.ops.object.shade_smooth()
    shackle.data.materials.append(create_chrome_material('ShackleChrome'))
    
    # Glowing Keyhole in the lock
    bpy.ops.mesh.primitive_cylinder_add(radius=0.075, depth=0.12, location=(0, -0.45, -0.12))
    keyhole = bpy.context.active_object
    keyhole.rotation_euler = (math.radians(90), 0, 0)
    keyhole.data.materials.append(create_emission_material('KeyGlow', '#00F0FF', strength=10.0))
    
    # Floating Holographic Data Ring around shield
    bpy.ops.mesh.primitive_torus_add(major_radius=1.5, minor_radius=0.035, location=(0, 0, 0))
    ring = bpy.context.active_object
    ring.rotation_euler = (math.radians(20), math.radians(50), 0)
    bpy.ops.object.shade_smooth()
    ring.data.materials.append(create_emission_material('HaloRing', '#00F0FF', strength=6.0))
    
    # Orbiting Data Nodes
    bpy.ops.mesh.primitive_uv_sphere_add(radius=0.15, location=(-1.3, -0.3, 0.85))
    s1 = bpy.context.active_object
    s1.data.materials.append(create_emission_material('Node1', '#57F287', strength=8.0))
    
    bpy.ops.mesh.primitive_uv_sphere_add(radius=0.18, location=(1.35, -0.2, -0.75))
    s2 = bpy.context.active_object
    s2.data.materials.append(create_emission_material('Node2', '#EB459E', strength=8.0))

# ==============================================
# 3. MODEL: DISCORD-STYLE 3D CORE SWITCH & SERVER
# ==============================================
def build_server_switch():
    # Main Switch Chassis
    bpy.ops.mesh.primitive_cube_add(size=1.0, location=(0, 0, 0))
    chassis = bpy.context.active_object
    chassis.scale = (2.4, 1.6, 0.8)
    bpy.ops.object.transform_apply(scale=True)
    bev = chassis.modifiers.new(name='Bevel', type='BEVEL')
    bev.width = 0.09
    bev.segments = 4
    bpy.ops.object.shade_smooth()
    chassis.data.materials.append(create_matte_clay_material('ChassisMat', '#1E1F22', roughness=0.3))
    
    # Front Recessed Port Bay (Attached to the front face y = -0.78)
    bpy.ops.mesh.primitive_cube_add(size=1.0, location=(0, -0.80, 0))
    front_bay = bpy.context.active_object
    front_bay.scale = (2.15, 0.08, 0.52)
    bpy.ops.object.transform_apply(scale=True)
    bev_f = front_bay.modifiers.new(name='Bevel', type='BEVEL')
    bev_f.width = 0.03
    bev_f.segments = 3
    bpy.ops.object.shade_smooth()
    front_bay.data.materials.append(create_matte_clay_material('BayMat', '#2B2D31', roughness=0.3))
    
    # 6 RJ-45 Port Sockets with Glowing Activity LEDs
    port_mat = create_matte_clay_material('PortDark', '#111214', roughness=0.6)
    led_green = create_emission_material('LedG', '#57F287', strength=8.0)
    led_cyan = create_emission_material('LedC', '#00F0FF', strength=8.0)
    led_blurple = create_emission_material('LedB', '#5865F2', strength=8.0)
    led_amber = create_emission_material('LedA', '#FEE75C', strength=8.0)
    led_colors = [led_green, led_cyan, led_blurple, led_green, led_cyan, led_amber]
    
    for i in range(6):
        x_pos = -0.88 + (i * 0.35)
        # Port hole
        bpy.ops.mesh.primitive_cube_add(size=0.18, location=(x_pos, -0.85, -0.06))
        port = bpy.context.active_object
        port.scale = (1.0, 0.2, 1.0)
        bpy.ops.object.transform_apply(scale=True)
        port.data.materials.append(port_mat)
        
        # Activity LED dot above port
        bpy.ops.mesh.primitive_uv_sphere_add(radius=0.042, segments=16, ring_count=8, location=(x_pos, -0.86, 0.14))
        led = bpy.context.active_object
        led.data.materials.append(led_colors[i])
        
    # Top Status Glass / Telemetry Screen
    bpy.ops.mesh.primitive_cube_add(size=1.0, location=(0, -0.05, 0.41))
    screen = bpy.context.active_object
    screen.scale = (2.0, 1.2, 0.04)
    bpy.ops.object.transform_apply(scale=True)
    bev_s = screen.modifiers.new(name='Bevel', type='BEVEL')
    bev_s.width = 0.04
    bev_s.segments = 3
    bpy.ops.object.shade_smooth()
    screen.data.materials.append(create_crystal_glass_material('TopScreen', '#0369A1', transmission=0.85))
    
    # Glowing Central Topology Ring on the top screen
    bpy.ops.mesh.primitive_torus_add(major_radius=0.42, minor_radius=0.038, location=(0, -0.05, 0.45))
    halo = bpy.context.active_object
    halo.rotation_euler = (0, 0, 0)
    bpy.ops.object.shade_smooth()
    halo.data.materials.append(create_emission_material('HaloEmis', '#5865F2', strength=8.0))
    
    # Glowing Network Node Points on the top screen
    node_coords = [(-0.6, -0.25, 0.44), (0.6, -0.25, 0.44), (0.0, 0.25, 0.44)]
    for pt in node_coords:
        bpy.ops.mesh.primitive_uv_sphere_add(radius=0.065, location=pt)
        dot = bpy.context.active_object
        dot.data.materials.append(create_emission_material('NodeDot', '#00F0FF', strength=9.0))
        
    # Orbiting Cloud Sphere (Floating Satellite)
    bpy.ops.mesh.primitive_uv_sphere_add(radius=0.24, location=(-1.7, -0.6, 0.65))
    sat1 = bpy.context.active_object
    sat1.data.materials.append(create_emission_material('SatGlow', '#57F287', strength=8.0))

# ============================================
# 4. MODEL: DISCORD-STYLE 3D WI-FI GIGABIT ROUTER
# ============================================
def build_wifi_router():
    # Sleek Curved Router Body
    bpy.ops.mesh.primitive_cube_add(size=1.0, location=(0, 0, 0))
    body = bpy.context.active_object
    body.scale = (1.9, 1.4, 0.45)
    bpy.ops.object.transform_apply(scale=True)
    bev = body.modifiers.new(name='Bevel', type='BEVEL')
    bev.width = 0.14
    bev.segments = 5
    bpy.ops.object.shade_smooth()
    body.data.materials.append(create_matte_clay_material('RouterBody', '#1E1F22', roughness=0.28))
    
    # Front Glowing Accent Line (Pulsing Cyan Strip)
    bpy.ops.mesh.primitive_cube_add(size=1.0, location=(0, -0.71, 0))
    strip = bpy.context.active_object
    strip.scale = (1.6, 0.04, 0.06)
    bpy.ops.object.transform_apply(scale=True)
    strip.data.materials.append(create_emission_material('NeonStrip', '#00F0FF', strength=10.0))
    
    # 4 Sleek Tilted Antennas
    antenna_mat = create_matte_clay_material('AntennaBase', '#2B2D31', roughness=0.3)
    antenna_glow = create_emission_material('AntennaGlow', '#5865F2', strength=8.0)
    
    antenna_positions = [
        (-0.85, 0.65, 0.55, -20, 15),
        (-0.3, 0.7, 0.6, -24, 5),
        (0.3, 0.7, 0.6, -24, -5),
        (0.85, 0.65, 0.55, -20, -15)
    ]
    
    for x, y, z, rot_x, rot_y in antenna_positions:
        bpy.ops.mesh.primitive_cylinder_add(radius=0.06, depth=1.1, vertices=16, location=(x, y, z))
        ant = bpy.context.active_object
        ant.rotation_euler = (math.radians(rot_x), math.radians(rot_y), 0)
        bpy.ops.object.transform_apply(rotation=True)
        bpy.ops.object.shade_smooth()
        ant.data.materials.append(antenna_mat)
        
        # Glowing Tip on each antenna
        bpy.ops.mesh.primitive_uv_sphere_add(radius=0.08, location=(x + (rot_y * -0.012), y + (rot_x * -0.015), z + 0.52))
        tip = bpy.context.active_object
        tip.data.materials.append(antenna_glow)
        
    # 3 Glowing Wi-Fi Signal Arcs (Expanding Radio Waves)
    wave_mat = create_emission_material('WaveGlow', '#57F287', strength=7.0)
    for i in range(3):
        r = 0.55 + (i * 0.35)
        bpy.ops.mesh.primitive_torus_add(major_radius=r, minor_radius=0.03, location=(0, -0.2, 0.4 + (i * 0.18)))
        wave = bpy.context.active_object
        wave.rotation_euler = (math.radians(25), 0, 0)
        bpy.ops.object.shade_smooth()
        wave.data.materials.append(wave_mat)

def render_all():
    out_dir = '/var/www/project_tkj_yuda2/public/images/discord_assets'
    os.makedirs(out_dir, exist_ok=True)
    
    assets = [
        {
            'name': 'RJ-45 Crystal Jack & Gold Pins',
            'builder': build_rj45_connector,
            'cam_loc': (-2.8, 3.8, 2.3),
            'look_at': (0, 0, 0.1),
            'png': os.path.join(out_dir, 'rj45_discord_3d.png'),
            'webp': os.path.join(out_dir, 'rj45_discord_3d.webp')
        },
        {
            'name': 'Cyber Security Shield & Key',
            'builder': build_cyber_shield,
            'cam_loc': (3.2, -4.0, 2.3),
            'look_at': (0, 0, 0),
            'png': os.path.join(out_dir, 'cyber_shield_discord_3d.png'),
            'webp': os.path.join(out_dir, 'cyber_shield_discord_3d.webp')
        },
        {
            'name': 'Core Switch & Cloud Server',
            'builder': build_server_switch,
            'cam_loc': (3.4, -4.2, 2.8),
            'look_at': (0, -0.2, 0.15),
            'png': os.path.join(out_dir, 'core_switch_discord_3d.png'),
            'webp': os.path.join(out_dir, 'core_switch_discord_3d.webp')
        },
        {
            'name': 'Wi-Fi 7 Gigabit Router',
            'builder': build_wifi_router,
            'cam_loc': (3.4, -4.2, 2.6),
            'look_at': (0, 0, 0.2),
            'png': os.path.join(out_dir, 'router_discord_3d.png'),
            'webp': os.path.join(out_dir, 'router_discord_3d.webp')
        }
    ]
    
    for item in assets:
        print(f"\n==========================================")
        print(f"Rendering Discord 3D Asset: {item['name']}")
        print(f"==========================================")
        clear_scene()
        scene = bpy.context.scene
        scene.render.engine = 'CYCLES'
        scene.cycles.use_denoising = False
        scene.cycles.samples = 128
        scene.render.film_transparent = True
        scene.render.resolution_x = 512
        scene.render.resolution_y = 512
        scene.render.filepath = item['png']
        scene.view_settings.view_transform = 'Standard'
        
        world = bpy.data.worlds.new('StudioWorld')
        world.use_nodes = True
        bg = world.node_tree.nodes.get('Background')
        bg.inputs['Color'].default_value = (0.02, 0.02, 0.04, 1.0)
        bg.inputs['Strength'].default_value = 0.05
        scene.world = world
        
        setup_camera_and_lights(scene, cam_loc=item['cam_loc'], look_at=item['look_at'])
        item['builder']()
        bpy.ops.render.render(write_still=True)
        
        if os.path.exists(item['png']):
            img = Image.open(item['png'])
            img.save(item['webp'], 'WEBP', quality=95)
            print(f"Successfully rendered: {item['png']} and {item['webp']}")

if __name__ == '__main__':
    render_all()
