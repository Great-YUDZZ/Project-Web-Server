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

def setup_studio_lighting(scene, cam_loc=(3.8, -4.5, 3.2), look_at=(0, 0, 0), lens=65):
    # Camera setup with Track To constraint
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
    
    # Key Light (Bright natural studio key)
    l1 = bpy.data.objects.new('KeyLight', bpy.data.lights.new('KeyLight', 'POINT'))
    l1.data.energy = 580
    l1.data.shadow_soft_size = 0.35
    l1.data.color = (1.0, 0.98, 0.96)
    l1.location = (4.5, -3.8, 4.2)
    scene.collection.objects.link(l1)
    
    # Fill Light (Subtle soft cool fill)
    l2 = bpy.data.objects.new('FillLight', bpy.data.lights.new('FillLight', 'POINT'))
    l2.data.energy = 260
    l2.data.shadow_soft_size = 0.5
    l2.data.color = (0.88, 0.92, 1.0)
    l2.location = (-4.2, -3.2, 1.8)
    scene.collection.objects.link(l2)
    
    # Rim Light 1 (Cyan-Blue Edge Accent)
    l3 = bpy.data.objects.new('RimCyan', bpy.data.lights.new('RimCyan', 'POINT'))
    l3.data.energy = 650
    l3.data.shadow_soft_size = 0.2
    l3.data.color = hex_to_linear('#38BDF8')[:3]
    l3.location = (-3.8, 3.8, 3.0)
    scene.collection.objects.link(l3)
    
    # Rim Light 2 (Soft Warm Rim from right-rear)
    l4 = bpy.data.objects.new('RimWarm', bpy.data.lights.new('RimWarm', 'POINT'))
    l4.data.energy = 400
    l4.data.shadow_soft_size = 0.25
    l4.data.color = (1.0, 0.95, 0.9)
    l4.location = (3.5, 3.8, 0.8)
    scene.collection.objects.link(l4)

# ==========================================
# MATERIALS HELPER
# ==========================================
def create_metal_material(name, hex_color='#2A2D34', roughness=0.25, metallic=0.9):
    mat = bpy.data.materials.new(name=name)
    mat.use_nodes = True
    p = mat.node_tree.nodes.get('Principled BSDF')
    r, g, b, _ = hex_to_linear(hex_color)
    p.inputs['Base Color'].default_value = (r, g, b, 1.0)
    p.inputs['Metallic'].default_value = metallic
    p.inputs['Roughness'].default_value = roughness
    return mat

def create_plastic_material(name, hex_color='#1E2024', roughness=0.35):
    mat = bpy.data.materials.new(name=name)
    mat.use_nodes = True
    p = mat.node_tree.nodes.get('Principled BSDF')
    r, g, b, _ = hex_to_linear(hex_color)
    p.inputs['Base Color'].default_value = (r, g, b, 1.0)
    p.inputs['Metallic'].default_value = 0.05
    p.inputs['Roughness'].default_value = roughness
    p.inputs['Coat Weight'].default_value = 0.3
    p.inputs['Coat Roughness'].default_value = 0.1
    return mat

def create_glass_material(name, hex_color='#E2F1FF', transmission=0.9, roughness=0.05):
    mat = bpy.data.materials.new(name=name)
    mat.use_nodes = True
    p = mat.node_tree.nodes.get('Principled BSDF')
    r, g, b, _ = hex_to_linear(hex_color)
    p.inputs['Base Color'].default_value = (r, g, b, 1.0)
    p.inputs['Transmission Weight'].default_value = transmission
    p.inputs['Roughness'].default_value = roughness
    p.inputs['IOR'].default_value = 1.48
    return mat

def create_emission_material(name, hex_color='#10B981', strength=6.0):
    mat = bpy.data.materials.new(name=name)
    mat.use_nodes = True
    mat.node_tree.nodes.clear()
    em = mat.node_tree.nodes.new('ShaderNodeEmission')
    em.inputs['Color'].default_value = hex_to_linear(hex_color)
    em.inputs['Strength'].default_value = strength
    out = mat.node_tree.nodes.new('ShaderNodeOutputMaterial')
    mat.node_tree.links.new(em.outputs['Emission'], out.inputs['Surface'])
    return mat

# ==========================================
# 1. MODEL: REALISTIC 3D KABEL LAN (ETHERNET)
# ==========================================
def build_lan_cable():
    cable_mat = create_plastic_material('CableJacket', '#0284C7', roughness=0.3)
    boot_mat = create_plastic_material('BootRubber', '#1E293B', roughness=0.4)
    glass_mat = create_glass_material('JackCrystal', '#E0F2FE', transmission=0.88, roughness=0.08)
    gold_mat = create_metal_material('GoldPins', '#FBBF24', roughness=0.15, metallic=1.0)
    clip_mat = create_plastic_material('LatchClip', '#0369A1', roughness=0.25)
    
    # 1. Main RJ-45 Crystal Plug Head
    bpy.ops.mesh.primitive_cube_add(size=1.0, location=(0.8, 0.4, 0.4))
    head = bpy.context.active_object
    head.scale = (0.7, 1.0, 0.5)
    head.rotation_euler = (math.radians(-15), math.radians(25), math.radians(-35))
    bpy.ops.object.transform_apply(scale=True, rotation=True)
    bev = head.modifiers.new(name='Bevel', type='BEVEL')
    bev.width = 0.05
    bev.segments = 4
    bpy.ops.object.shade_smooth()
    head.data.materials.append(glass_mat)
    
    # 2. Golden Contact Pins on the front of the plug
    for i in range(8):
        x_offset = -0.22 + (i * 0.065)
        bpy.ops.mesh.primitive_cube_add(size=0.06, location=(0.8 + x_offset, 0.82, 0.55))
        pin = bpy.context.active_object
        pin.scale = (0.4, 1.2, 0.3)
        pin.rotation_euler = (math.radians(-15), math.radians(25), math.radians(-35))
        bpy.ops.object.transform_apply(scale=True, rotation=True)
        bpy.ops.object.shade_smooth()
        pin.data.materials.append(gold_mat)
        
    # 3. Snagless Latch Clip on top
    bpy.ops.mesh.primitive_cube_add(size=0.1, location=(0.78, 0.38, 0.72))
    clip = bpy.context.active_object
    clip.scale = (2.2, 7.5, 0.6)
    clip.rotation_euler = (math.radians(-28), math.radians(25), math.radians(-35))
    bpy.ops.object.transform_apply(scale=True, rotation=True)
    bpy.ops.object.shade_smooth()
    clip.data.materials.append(clip_mat)
    
    # 4. Rubber Strain Relief Boot collar
    bpy.ops.mesh.primitive_cylinder_add(radius=0.32, depth=0.5, vertices=24, location=(0.75, -0.15, 0.22))
    boot = bpy.context.active_object
    boot.rotation_euler = (math.radians(75), math.radians(-25), math.radians(35))
    bpy.ops.object.transform_apply(rotation=True)
    bev_b = boot.modifiers.new(name='Bevel', type='BEVEL')
    bev_b.width = 0.04
    bev_b.segments = 3
    bpy.ops.object.shade_smooth()
    boot.data.materials.append(boot_mat)
    
    # 5. Dynamic Graceful Coiled / Floating UTP Cable (Bezier Curve in 3D)
    bpy.ops.curve.primitive_bezier_curve_add(location=(0, 0, 0))
    curve = bpy.context.active_object
    curve.data.bevel_depth = 0.18
    curve.data.bevel_resolution = 12
    curve.data.use_fill_caps = True
    
    # Add multiple control points to make a realistic looping cable curve
    spline = curve.data.splines[0]
    spline.bezier_points.add(3)  # 5 total points
    
    pts = spline.bezier_points
    # Point 0: at the boot exit
    pts[0].co = (0.75, -0.38, 0.12)
    pts[0].handle_left = (0.78, -0.2, 0.22)
    pts[0].handle_right = (0.68, -0.8, -0.1)
    
    # Point 1: Loop bottom
    pts[1].co = (0.2, -1.2, -0.45)
    pts[1].handle_left = (0.6, -1.1, -0.3)
    pts[1].handle_right = (-0.3, -1.3, -0.5)
    
    # Point 2: Rising loop curve
    pts[2].co = (-0.9, -0.5, 0.1)
    pts[2].handle_left = (-0.8, -1.0, -0.2)
    pts[2].handle_right = (-0.8, 0.3, 0.4)
    
    # Point 3: Arching top
    pts[3].co = (-0.4, 0.9, 0.7)
    pts[3].handle_left = (-0.7, 0.7, 0.6)
    pts[3].handle_right = (0.0, 1.1, 0.65)
    
    # Point 4: Trailing off gracefully
    pts[4].co = (0.5, 1.2, 0.5)
    pts[4].handle_left = (0.2, 1.2, 0.6)
    pts[4].handle_right = (0.8, 1.2, 0.35)
    
    curve.data.materials.append(cable_mat)

# ==========================================
# 2. MODEL: REALISTIC 3D ENTERPRISE SERVER
# ==========================================
def build_enterprise_server():
    chassis_mat = create_metal_material('ServerChassis', '#1E222A', roughness=0.32, metallic=0.88)
    front_plate_mat = create_metal_material('FrontPlate', '#11141A', roughness=0.4, metallic=0.7)
    caddy_metal = create_metal_material('DriveCaddy', '#374151', roughness=0.25, metallic=0.92)
    handle_metal = create_metal_material('RackHandle', '#9CA3AF', roughness=0.18, metallic=0.95)
    led_green = create_emission_material('LedGreen', '#10B981', strength=7.0)
    led_blue = create_emission_material('LedBlue', '#38BDF8', strength=8.0)
    led_amber = create_emission_material('LedAmber', '#F59E0B', strength=6.0)
    
    # 1. Main 2U Rack Server Chassis Box
    bpy.ops.mesh.primitive_cube_add(size=1.0, location=(0, 0, 0))
    server = bpy.context.active_object
    server.scale = (2.2, 2.6, 0.7)
    server.rotation_euler = (math.radians(-10), math.radians(15), math.radians(-25))
    bpy.ops.object.transform_apply(scale=True, rotation=True)
    bev = server.modifiers.new(name='Bevel', type='BEVEL')
    bev.width = 0.05
    bev.segments = 4
    bpy.ops.object.shade_smooth()
    server.data.materials.append(chassis_mat)
    
    # 2. Left & Right Rack Mount Ears with Chrome Handles
    for side in [-1, 1]:
        # Ear bracket
        bpy.ops.mesh.primitive_cube_add(size=0.1, location=(side * 1.18, -1.05, 0.2))
        ear = bpy.context.active_object
        ear.scale = (0.6, 1.2, 5.8)
        ear.rotation_euler = (math.radians(-10), math.radians(15), math.radians(-25))
        bpy.ops.object.transform_apply(scale=True, rotation=True)
        ear.data.materials.append(handle_metal)
        
        # Chrome Tubular Handle
        bpy.ops.mesh.primitive_cylinder_add(radius=0.035, depth=0.42, vertices=16, location=(side * 1.25, -1.18, 0.24))
        handle = bpy.context.active_object
        handle.rotation_euler = (math.radians(-10), math.radians(15), math.radians(-25))
        bpy.ops.object.transform_apply(rotation=True)
        bpy.ops.object.shade_smooth()
        handle.data.materials.append(handle_metal)
        
    # 3. Front Drive Bays: 8 Hot-Swap HDD/SSD Caddies (2 rows of 4)
    for row in range(2):
        for col in range(4):
            x_pos = -0.72 + (col * 0.48)
            z_pos = -0.14 + (row * 0.28)
            y_pos = -1.15
            
            # Caddy body
            bpy.ops.mesh.primitive_cube_add(size=0.1, location=(x_pos, y_pos, z_pos))
            caddy = bpy.context.active_object
            caddy.scale = (4.2, 0.5, 2.2)
            caddy.rotation_euler = (math.radians(-10), math.radians(15), math.radians(-25))
            bpy.ops.object.transform_apply(scale=True, rotation=True)
            caddy.data.materials.append(caddy_metal)
            
            # Caddy Latch Handle
            bpy.ops.mesh.primitive_cube_add(size=0.05, location=(x_pos, y_pos - 0.05, z_pos))
            latch = bpy.context.active_object
            latch.scale = (3.5, 0.4, 0.5)
            latch.rotation_euler = (math.radians(-10), math.radians(15), math.radians(-25))
            bpy.ops.object.transform_apply(scale=True, rotation=True)
            latch.data.materials.append(handle_metal)
            
            # Drive Status LED
            led_choice = led_green if (row + col) % 3 != 0 else led_blue
            bpy.ops.mesh.primitive_uv_sphere_add(radius=0.022, segments=12, ring_count=6, location=(x_pos + 0.16, y_pos - 0.06, z_pos + 0.07))
            led = bpy.context.active_object
            led.rotation_euler = (math.radians(-10), math.radians(15), math.radians(-25))
            bpy.ops.object.transform_apply(rotation=True)
            led.data.materials.append(led_choice)
            
    # 4. Top/Front Power & ID Status Bar
    bpy.ops.mesh.primitive_cube_add(size=0.08, location=(-0.85, -1.18, 0.32))
    pwr = bpy.context.active_object
    pwr.scale = (0.8, 0.4, 0.8)
    pwr.rotation_euler = (math.radians(-10), math.radians(15), math.radians(-25))
    bpy.ops.object.transform_apply(scale=True, rotation=True)
    pwr.data.materials.append(led_blue)

# ==========================================
# 3. MODEL: REALISTIC 3D SYSADMIN LAPTOP
# ==========================================
def build_sysadmin_laptop():
    body_metal = create_metal_material('LaptopBody', '#1F242D', roughness=0.25, metallic=0.92)
    kb_mat = create_plastic_material('Keycaps', '#111317', roughness=0.45)
    screen_bezel = create_plastic_material('ScreenBezel', '#0A0C0F', roughness=0.3)
    trackpad_mat = create_metal_material('Trackpad', '#252B35', roughness=0.18, metallic=0.85)
    
    # 1. Base Keyboard Deck (Horizontal base chassis)
    bpy.ops.mesh.primitive_cube_add(size=1.0, location=(0, 0, 0))
    deck = bpy.context.active_object
    deck.scale = (2.2, 1.5, 0.07)
    deck.rotation_euler = (math.radians(12), math.radians(-18), math.radians(22))
    bpy.ops.object.transform_apply(scale=True, rotation=True)
    bev_d = deck.modifiers.new(name='Bevel', type='BEVEL')
    bev_d.width = 0.03
    bev_d.segments = 4
    bpy.ops.object.shade_smooth()
    deck.data.materials.append(body_metal)
    
    # 2. Keyboard Inset & Key Grid
    bpy.ops.mesh.primitive_cube_add(size=1.0, location=(0, 0.18, 0.06))
    kb_well = bpy.context.active_object
    kb_well.scale = (1.9, 0.85, 0.04)
    kb_well.rotation_euler = (math.radians(12), math.radians(-18), math.radians(22))
    bpy.ops.object.transform_apply(scale=True, rotation=True)
    kb_well.data.materials.append(kb_mat)
    
    # 3. Glass Trackpad
    bpy.ops.mesh.primitive_cube_add(size=1.0, location=(0, -0.48, 0.05))
    trackpad = bpy.context.active_object
    trackpad.scale = (0.8, 0.48, 0.03)
    trackpad.rotation_euler = (math.radians(12), math.radians(-18), math.radians(22))
    bpy.ops.object.transform_apply(scale=True, rotation=True)
    trackpad.data.materials.append(trackpad_mat)
    
    # 4. Display Lid (Tilted back at ~115 degrees)
    bpy.ops.mesh.primitive_cube_add(size=1.0, location=(0, 0.75, 0.72))
    lid = bpy.context.active_object
    lid.scale = (2.2, 0.05, 1.45)
    lid.rotation_euler = (math.radians(-22), math.radians(-18), math.radians(22))
    bpy.ops.object.transform_apply(scale=True, rotation=True)
    bev_l = lid.modifiers.new(name='Bevel', type='BEVEL')
    bev_l.width = 0.025
    bev_l.segments = 4
    bpy.ops.object.shade_smooth()
    lid.data.materials.append(screen_bezel)
    
    # 5. Glowing Cyber Terminal Screen
    screen_mat = bpy.data.materials.new(name='TerminalScreen')
    screen_mat.use_nodes = True
    screen_mat.node_tree.nodes.clear()
    
    # Dark navy terminal background with glowing cyber green / cyan command text
    em_screen = screen_mat.node_tree.nodes.new('ShaderNodeEmission')
    em_screen.inputs['Color'].default_value = hex_to_linear('#081B26')
    em_screen.inputs['Strength'].default_value = 2.5
    
    out_s = screen_mat.node_tree.nodes.new('ShaderNodeOutputMaterial')
    screen_mat.node_tree.links.new(em_screen.outputs['Emission'], out_s.inputs['Surface'])
    
    bpy.ops.mesh.primitive_cube_add(size=1.0, location=(0, 0.72, 0.72))
    screen_panel = bpy.context.active_object
    screen_panel.scale = (2.05, 0.03, 1.3)
    screen_panel.rotation_euler = (math.radians(-22), math.radians(-18), math.radians(22))
    bpy.ops.object.transform_apply(scale=True, rotation=True)
    screen_panel.data.materials.append(screen_mat)
    
    # Code Line Text Glow bars on the screen (Terminal Output Simulation)
    code_cyan = create_emission_material('CodeCyan', '#38BDF8', strength=6.0)
    code_green = create_emission_material('CodeGreen', '#10B981', strength=7.0)
    code_white = create_emission_material('CodeWhite', '#E2E8F0', strength=5.0)
    
    lines = [
        (-0.35, 0.35, 1.6, code_cyan),     # yuda@sysadmin:~$ netstat -tuln
        (-0.2, 0.15, 1.3, code_green),     # [OK] Core Switch 10.0.0.1 Active
        (-0.3, -0.05, 1.5, code_white),    # Port 443 (HTTPS) LISTEN 0.0.0.0:*
        (-0.15, -0.25, 1.2, code_green)    # Latency: 1.2ms [Bandwidth: 10Gbps]
    ]
    for x_c, z_c, width, mat_c in lines:
        bpy.ops.mesh.primitive_cube_add(size=0.03, location=(x_c, 0.70 - (z_c * 0.08), 0.72 + z_c))
        line_bar = bpy.context.active_object
        line_bar.scale = (width * 6.0, 0.3, 0.6)
        line_bar.rotation_euler = (math.radians(-22), math.radians(-18), math.radians(22))
        bpy.ops.object.transform_apply(scale=True, rotation=True)
        line_bar.data.materials.append(mat_c)

# ==========================================
# RENDER DISPATCHER
# ==========================================
def render_hardware_assets():
    out_dir = '/var/www/project_tkj_yuda2/public/images/discord_assets'
    os.makedirs(out_dir, exist_ok=True)
    
    assets = [
        {
            'name': 'Kabel LAN Cat6 / Patch Cable',
            'builder': build_lan_cable,
            'cam_loc': (3.2, -4.2, 2.6),
            'look_at': (0.1, 0, 0.2),
            'png': os.path.join(out_dir, 'kabel_lan_3d.png'),
            'webp': os.path.join(out_dir, 'kabel_lan_3d.webp')
        },
        {
            'name': 'Enterprise Server Unit',
            'builder': build_enterprise_server,
            'cam_loc': (3.6, -4.5, 3.0),
            'look_at': (0, -0.2, 0.1),
            'png': os.path.join(out_dir, 'server_rack_3d.png'),
            'webp': os.path.join(out_dir, 'server_rack_3d.webp')
        },
        {
            'name': 'SysAdmin Laptop Terminal',
            'builder': build_sysadmin_laptop,
            'cam_loc': (3.4, -4.2, 2.8),
            'look_at': (0, 0.1, 0.4),
            'png': os.path.join(out_dir, 'laptop_terminal_3d.png'),
            'webp': os.path.join(out_dir, 'laptop_terminal_3d.webp')
        }
    ]
    
    for item in assets:
        print(f"\n==========================================")
        print(f"Rendering Realistic Hardware Asset: {item['name']}")
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
        
        setup_studio_lighting(scene, cam_loc=item['cam_loc'], look_at=item['look_at'])
        item['builder']()
        bpy.ops.render.render(write_still=True)
        
        if os.path.exists(item['png']):
            img = Image.open(item['png'])
            img.save(item['webp'], 'WEBP', quality=95)
            print(f"Rendered: {item['png']} & {item['webp']}")

if __name__ == '__main__':
    render_hardware_assets()
