"""
Blender 3D Script to Generate Discord Mascot Characters
1. Clyde Robo-Bot (Peeking Mascot matching user reference screenshot)
2. Discord Wumpus (Plush mascot with horns and waving pose)
3. Cyber Drone (Floating Discord tech companion)
"""

import bpy
import math
import os

OUTPUT_DIR = "/var/www/project_tkj_yuda2/public/images/discord_mascots"
os.makedirs(OUTPUT_DIR, exist_ok=True)

def reset_scene():
    bpy.ops.wm.read_factory_settings(use_empty=True)
    scene = bpy.context.scene
    scene.render.engine = 'BLENDER_EEVEE_NEXT'
    scene.render.film_transparent = True
    scene.render.image_settings.file_format = 'PNG'
    scene.render.image_settings.color_mode = 'RGBA'
    scene.render.resolution_x = 640
    scene.render.resolution_y = 640
    scene.render.resolution_percentage = 100
    
    # World background
    world = bpy.data.worlds.new(name="MascotWorld")
    scene.world = world
    world.use_nodes = True
    bg_node = world.node_tree.nodes.get("Background")
    if bg_node:
        bg_node.inputs[0].default_value = (0.05, 0.05, 0.1, 1.0)
        bg_node.inputs[1].default_value = 0.5
    return scene

def setup_lights():
    # Key light (soft warm white)
    key_data = bpy.data.lights.new(name="KeyLight", type='AREA')
    key_data.energy = 280.0
    key_data.size = 2.5
    key_data.color = (1.0, 0.98, 0.95)
    key_obj = bpy.data.objects.new(name="KeyLight", object_data=key_data)
    bpy.context.collection.objects.link(key_obj)
    key_obj.location = (2.2, -2.8, 3.0)
    key_obj.rotation_euler = (math.radians(50), 0, math.radians(35))

    # Fill light (cool blurple)
    fill_data = bpy.data.lights.new(name="FillLight", type='AREA')
    fill_data.energy = 160.0
    fill_data.size = 3.0
    fill_data.color = (0.35, 0.45, 0.95)
    fill_obj = bpy.data.objects.new(name="FillLight", object_data=fill_data)
    bpy.context.collection.objects.link(fill_obj)
    fill_obj.location = (-2.5, -2.0, 1.5)
    fill_obj.rotation_euler = (math.radians(45), 0, math.radians(-45))

    # Rim light (bright cyan/teal)
    rim_data = bpy.data.lights.new(name="RimLight", type='POINT')
    rim_data.energy = 320.0
    rim_data.color = (0.2, 0.8, 1.0)
    rim_obj = bpy.data.objects.new(name="RimLight", object_data=rim_data)
    bpy.context.collection.objects.link(rim_obj)
    rim_obj.location = (0.0, 2.5, 2.2)

def create_camera(loc=(0, -3.8, 0.5), rot=(math.radians(82), 0, 0), focal=55):
    cam_data = bpy.data.cameras.new(name="MascotCamera")
    cam_data.lens = focal
    cam_obj = bpy.data.objects.new(name="MascotCamera", object_data=cam_data)
    bpy.context.collection.objects.link(cam_obj)
    bpy.context.scene.camera = cam_obj
    cam_obj.location = loc
    cam_obj.rotation_euler = rot
    return cam_obj

def make_material(name, base_color, roughness=0.3, metallic=0.0, emission_color=None, emission_strength=0.0):
    mat = bpy.data.materials.new(name=name)
    mat.use_nodes = True
    nodes = mat.node_tree.nodes
    bsdf = nodes.get("Principled BSDF")
    if bsdf:
        bsdf.inputs["Base Color"].default_value = base_color
        bsdf.inputs["Roughness"].default_value = roughness
        bsdf.inputs["Metallic"].default_value = metallic
        if emission_color:
            bsdf.inputs["Emission Color"].default_value = emission_color
            bsdf.inputs["Emission Strength"].default_value = emission_strength
    return mat

def create_clyde_peeking():
    """Models Clyde Robo-Bot (Peeking over card)"""
    scene = reset_scene()
    setup_lights()
    create_camera(loc=(0, -4.4, 0.45), rot=(math.radians(86), 0, 0), focal=52)

    # Materials
    blurple_mat = make_material("BlurpleBody", (0.345, 0.396, 0.949, 1.0), roughness=0.25, metallic=0.1)
    screen_mat = make_material("DarkScreen", (0.08, 0.09, 0.14, 1.0), roughness=0.15, metallic=0.4)
    led_cyan_mat = make_material("LEDEyes", (0.1, 0.85, 1.0, 1.0), roughness=0.1, emission_color=(0.1, 0.9, 1.0, 1.0), emission_strength=4.5)
    accent_dark_mat = make_material("EarAccent", (0.18, 0.20, 0.35, 1.0), roughness=0.3, metallic=0.2)

    # 1. Head (Rounded Box)
    bpy.ops.mesh.primitive_cube_add(size=1.0, location=(0, 0, 0.5))
    head = bpy.context.active_object
    head.scale = (1.1, 0.75, 0.85)
    bpy.ops.object.transform_apply(scale=True)
    
    # Bevel modifier for rounded corners
    bevel = head.modifiers.new(name="Bevel", type='BEVEL')
    bevel.width = 0.22
    bevel.segments = 6
    subsurf = head.modifiers.new(name="Subsurf", type='SUBSURF')
    subsurf.levels = 2
    subsurf.render_levels = 2
    bpy.ops.object.shade_smooth()
    head.data.materials.append(blurple_mat)

    # 2. Screen Face (Recessed curved rectangle)
    bpy.ops.mesh.primitive_cube_add(size=1.0, location=(0, -0.38, 0.5))
    screen = bpy.context.active_object
    screen.scale = (0.82, 0.1, 0.55)
    bpy.ops.object.transform_apply(scale=True)
    s_bevel = screen.modifiers.new(name="Bevel", type='BEVEL')
    s_bevel.width = 0.12
    s_bevel.segments = 5
    bpy.ops.object.shade_smooth()
    screen.data.materials.append(screen_mat)

    # 3. LED Eyes (Left and Right horizontal pills / capsules)
    for sign, name in [(-1, "LeftEye"), (1, "RightEye")]:
        bpy.ops.mesh.primitive_cylinder_add(radius=0.07, depth=0.22, location=(sign * 0.24, -0.45, 0.5))
        eye = bpy.context.active_object
        eye.rotation_euler = (0, math.radians(90), 0)
        eye_bevel = eye.modifiers.new(name="Bevel", type='BEVEL')
        eye_bevel.width = 0.04
        eye_bevel.segments = 3
        bpy.ops.object.shade_smooth()
        eye.data.materials.append(led_cyan_mat)

    # 4. Ear Pads / Cylinders (Left and Right)
    for sign, name in [(-1, "LeftEar"), (1, "RightEar")]:
        bpy.ops.mesh.primitive_cylinder_add(radius=0.24, depth=0.22, location=(sign * 0.68, 0, 0.5))
        ear = bpy.context.active_object
        ear.rotation_euler = (0, math.radians(90), 0)
        ear_bev = ear.modifiers.new(name="Bevel", type='BEVEL')
        ear_bev.width = 0.05
        ear_bev.segments = 4
        bpy.ops.object.shade_smooth()
        ear.data.materials.append(accent_dark_mat)
        
        # Inner ear cap
        bpy.ops.mesh.primitive_cylinder_add(radius=0.16, depth=0.28, location=(sign * 0.70, 0, 0.5))
        inner_ear = bpy.context.active_object
        inner_ear.rotation_euler = (0, math.radians(90), 0)
        bpy.ops.object.shade_smooth()
        inner_ear.data.materials.append(blurple_mat)

    # 5. Top Antenna with glowing sphere
    bpy.ops.mesh.primitive_cylinder_add(radius=0.04, depth=0.25, location=(0, 0, 0.98))
    ant_stem = bpy.context.active_object
    ant_stem.data.materials.append(accent_dark_mat)
    
    bpy.ops.mesh.primitive_uv_sphere_add(radius=0.09, location=(0, 0, 1.14))
    ant_orb = bpy.context.active_object
    bpy.ops.object.shade_smooth()
    ant_orb.data.materials.append(led_cyan_mat)

    # 6. Torso / Shoulders peeking up
    bpy.ops.mesh.primitive_cylinder_add(radius=0.7, depth=0.6, location=(0, 0.05, -0.2))
    torso = bpy.context.active_object
    t_bev = torso.modifiers.new(name="Bevel", type='BEVEL')
    t_bev.width = 0.18
    t_bev.segments = 5
    bpy.ops.object.shade_smooth()
    torso.data.materials.append(blurple_mat)

    # 7. Cute Hands gripping the card edge
    for sign in [-1, 1]:
        bpy.ops.mesh.primitive_uv_sphere_add(radius=0.14, location=(sign * 0.42, -0.36, -0.02))
        hand = bpy.context.active_object
        hand.scale = (1.2, 0.9, 0.7)
        bpy.ops.object.shade_smooth()
        hand.data.materials.append(accent_dark_mat)

    # Render
    output_png = os.path.join(OUTPUT_DIR, "clyde_peeking.png")
    scene.render.filepath = output_png
    bpy.ops.render.render(write_still=True)
    print(f"Rendered Clyde Peeking to {output_png}")

def create_wumpus():
    """Models Discord Wumpus Plush Mascot"""
    scene = reset_scene()
    setup_lights()
    create_camera(loc=(0, -4.6, 0.55), rot=(math.radians(85), 0, 0), focal=52)

    # Materials
    wumpus_mat = make_material("WumpusPlush", (0.47, 0.52, 0.96, 1.0), roughness=0.55, metallic=0.0)
    muzzle_mat = make_material("WumpusMuzzle", (0.68, 0.73, 0.98, 1.0), roughness=0.5, metallic=0.0)
    horn_mat = make_material("WumpusHorn", (0.95, 0.72, 0.35, 1.0), roughness=0.3, metallic=0.1)
    dark_mat = make_material("WumpusEyesNose", (0.1, 0.12, 0.18, 1.0), roughness=0.2, metallic=0.1)
    belly_mat = make_material("WumpusBelly", (0.75, 0.80, 0.99, 1.0), roughness=0.6)

    # 1. Pear-shaped Body
    bpy.ops.mesh.primitive_uv_sphere_add(radius=0.85, location=(0, 0, 0.3))
    body = bpy.context.active_object
    body.scale = (0.95, 0.85, 1.15)
    bpy.ops.object.transform_apply(scale=True)
    bpy.ops.object.shade_smooth()
    body.data.materials.append(wumpus_mat)

    # 2. Belly Patch
    bpy.ops.mesh.primitive_uv_sphere_add(radius=0.5, location=(0, -0.42, 0.15))
    belly = bpy.context.active_object
    belly.scale = (0.85, 0.25, 0.95)
    bpy.ops.object.transform_apply(scale=True)
    bpy.ops.object.shade_smooth()
    belly.data.materials.append(belly_mat)

    # 3. Muzzle / Snout
    bpy.ops.mesh.primitive_uv_sphere_add(radius=0.32, location=(0, -0.65, 0.45))
    muzzle = bpy.context.active_object
    muzzle.scale = (1.05, 0.65, 0.75)
    bpy.ops.object.transform_apply(scale=True)
    bpy.ops.object.shade_smooth()
    muzzle.data.materials.append(muzzle_mat)

    # 4. Nose
    bpy.ops.mesh.primitive_uv_sphere_add(radius=0.08, location=(0, -0.84, 0.52))
    nose = bpy.context.active_object
    nose.scale = (1.2, 0.7, 0.7)
    bpy.ops.object.shade_smooth()
    nose.data.materials.append(dark_mat)

    # 5. Eyes
    for sign in [-1, 1]:
        bpy.ops.mesh.primitive_uv_sphere_add(radius=0.075, location=(sign * 0.24, -0.68, 0.68))
        eye = bpy.context.active_object
        eye.scale = (0.85, 0.6, 1.1)
        bpy.ops.object.shade_smooth()
        eye.data.materials.append(dark_mat)
        
        # Eye catchlight
        bpy.ops.mesh.primitive_uv_sphere_add(radius=0.025, location=(sign * 0.22, -0.74, 0.72))
        glint = bpy.context.active_object
        glint_mat = make_material("Glint", (1, 1, 1, 1), roughness=0.1)
        glint.data.materials.append(glint_mat)

    # 6. Cute Horns / Ears
    for sign in [-1, 1]:
        bpy.ops.mesh.primitive_cone_add(radius1=0.18, radius2=0.04, depth=0.45, location=(sign * 0.48, 0.05, 1.15))
        horn = bpy.context.active_object
        horn.rotation_euler = (math.radians(-15), sign * math.radians(-35), sign * math.radians(-20))
        bpy.ops.object.shade_smooth()
        horn.data.materials.append(horn_mat)

    # 7. Arms (Right arm waving!)
    # Left arm resting
    bpy.ops.mesh.primitive_cylinder_add(radius=0.13, depth=0.45, location=(-0.75, -0.1, 0.25))
    left_arm = bpy.context.active_object
    left_arm.rotation_euler = (math.radians(30), math.radians(20), math.radians(15))
    bpy.ops.object.shade_smooth()
    left_arm.data.materials.append(wumpus_mat)

    # Right arm waving up
    bpy.ops.mesh.primitive_cylinder_add(radius=0.13, depth=0.45, location=(0.78, -0.15, 0.55))
    right_arm = bpy.context.active_object
    right_arm.rotation_euler = (math.radians(-35), math.radians(-45), math.radians(-30))
    bpy.ops.object.shade_smooth()
    right_arm.data.materials.append(wumpus_mat)

    # Render
    output_png = os.path.join(OUTPUT_DIR, "wumpus_mascot.png")
    scene.render.filepath = output_png
    bpy.ops.render.render(write_still=True)
    print(f"Rendered Wumpus to {output_png}")

def create_cyber_drone():
    """Models Discord Cyber Drone Companion"""
    scene = reset_scene()
    setup_lights()
    create_camera(loc=(0, -4.2, 0.35), rot=(math.radians(88), 0, 0), focal=52)

    # Materials
    metal_dark = make_material("DroneBody", (0.12, 0.14, 0.25, 1.0), roughness=0.2, metallic=0.7)
    blurple_accent = make_material("DroneBlurple", (0.35, 0.40, 0.95, 1.0), roughness=0.3, metallic=0.3)
    glow_cyan = make_material("DroneGlow", (0.0, 0.9, 1.0, 1.0), roughness=0.1, emission_color=(0.0, 0.9, 1.0, 1.0), emission_strength=5.0)
    glow_violet = make_material("ThrusterGlow", (0.6, 0.2, 1.0, 1.0), roughness=0.1, emission_color=(0.7, 0.2, 1.0, 1.0), emission_strength=4.0)

    # 1. Main Spherical Orb Body
    bpy.ops.mesh.primitive_uv_sphere_add(radius=0.75, location=(0, 0, 0.1))
    body = bpy.context.active_object
    body.scale = (1.0, 0.9, 0.95)
    bpy.ops.object.transform_apply(scale=True)
    bpy.ops.object.shade_smooth()
    body.data.materials.append(metal_dark)

    # 2. Central Visor / Screen Ring
    bpy.ops.mesh.primitive_torus_add(major_radius=0.74, minor_radius=0.06, location=(0, 0, 0.1))
    ring = bpy.context.active_object
    ring.rotation_euler = (math.radians(90), 0, 0)
    bpy.ops.object.shade_smooth()
    ring.data.materials.append(blurple_accent)

    # 3. Glowing Cyber Eye / Lens
    bpy.ops.mesh.primitive_uv_sphere_add(radius=0.28, location=(0, -0.66, 0.1))
    lens = bpy.context.active_object
    lens.scale = (1.0, 0.4, 1.0)
    bpy.ops.object.transform_apply(scale=True)
    bpy.ops.object.shade_smooth()
    lens.data.materials.append(glow_cyan)

    # 4. Side Thruster Pods (Left & Right)
    for sign in [-1, 1]:
        bpy.ops.mesh.primitive_cylinder_add(radius=0.2, depth=0.45, location=(sign * 0.92, 0, 0.1))
        thruster = bpy.context.active_object
        thruster.rotation_euler = (math.radians(15), sign * math.radians(20), 0)
        bpy.ops.object.shade_smooth()
        thruster.data.materials.append(metal_dark)
        
        # Thruster Glow Core
        bpy.ops.mesh.primitive_cylinder_add(radius=0.12, depth=0.1, location=(sign * 0.96, 0.18, 0.05))
        flame = bpy.context.active_object
        flame.rotation_euler = (math.radians(15), sign * math.radians(20), 0)
        bpy.ops.object.shade_smooth()
        flame.data.materials.append(glow_violet)

    # 5. Top Antenna
    bpy.ops.mesh.primitive_cylinder_add(radius=0.03, depth=0.35, location=(0, 0, 0.95))
    ant = bpy.context.active_object
    ant.data.materials.append(metal_dark)

    bpy.ops.mesh.primitive_uv_sphere_add(radius=0.08, location=(0, 0, 1.15))
    beacon = bpy.context.active_object
    bpy.ops.object.shade_smooth()
    beacon.data.materials.append(glow_cyan)

    # Render
    output_png = os.path.join(OUTPUT_DIR, "cyber_drone.png")
    scene.render.filepath = output_png
    bpy.ops.render.render(write_still=True)
    print(f"Rendered Cyber Drone to {output_png}")

if __name__ == "__main__":
    print("Starting Blender Discord Mascot generation...")
    create_clyde_peeking()
    create_wumpus()
    create_cyber_drone()
    print("All Discord mascots rendered successfully!")
