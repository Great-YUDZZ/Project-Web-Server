"""
Blender 3D Script to Generate Discord Background Floating Motifs
1. Floating Crown (Matching pink/magenta floating crown in discord.com background)
2. Floating Trophy (Matching golden/purple floating cup in discord.com background)
3. Floating Gamepad / Controller (Matching retro Discord game controller)
"""

import bpy
import math
import os
from PIL import Image

OUTPUT_DIR = "/var/www/project_tkj_yuda2/public/images/discord_assets"
os.makedirs(OUTPUT_DIR, exist_ok=True)

def reset_scene():
    bpy.ops.wm.read_factory_settings(use_empty=True)
    scene = bpy.context.scene
    scene.render.engine = 'BLENDER_EEVEE_NEXT'
    scene.render.film_transparent = True
    scene.render.image_settings.file_format = 'PNG'
    scene.render.image_settings.color_mode = 'RGBA'
    scene.render.resolution_x = 512
    scene.render.resolution_y = 512
    scene.render.resolution_percentage = 100

    world = bpy.data.worlds.new(name="MotifWorld")
    scene.world = world
    world.use_nodes = True
    bg_node = world.node_tree.nodes.get("Background")
    if bg_node:
        bg_node.inputs[0].default_value = (0.05, 0.05, 0.1, 1.0)
        bg_node.inputs[1].default_value = 0.5
    return scene

def setup_lights():
    # Key light (warm soft pink/white)
    key_data = bpy.data.lights.new(name="KeyLight", type='AREA')
    key_data.energy = 380.0
    key_data.size = 3.5
    key_data.color = (1.0, 0.95, 0.98)
    key_obj = bpy.data.objects.new(name="KeyLight", object_data=key_data)
    bpy.context.collection.objects.link(key_obj)
    key_obj.location = (2.5, -4.5, 3.5)
    key_obj.rotation_euler = (math.radians(50), 0, math.radians(35))

    # Fill light (Discord blurple)
    fill_data = bpy.data.lights.new(name="FillLight", type='AREA')
    fill_data.energy = 260.0
    fill_data.size = 4.0
    fill_data.color = (0.4, 0.5, 1.0)
    fill_obj = bpy.data.objects.new(name="FillLight", object_data=fill_data)
    bpy.context.collection.objects.link(fill_obj)
    fill_obj.location = (-3.2, -3.5, 2.0)
    fill_obj.rotation_euler = (math.radians(45), 0, math.radians(-45))

    # Rim light (vibrant electric magenta / cyan)
    rim_data = bpy.data.lights.new(name="RimLight", type='POINT')
    rim_data.energy = 450.0
    rim_data.color = (0.95, 0.25, 0.85)
    rim_obj = bpy.data.objects.new(name="RimLight", object_data=rim_data)
    bpy.context.collection.objects.link(rim_obj)
    rim_obj.location = (0.0, 3.0, 3.0)

def create_camera(loc=(0, -6.8, 1.0), rot=(math.radians(82), 0, 0), focal=45):
    cam_data = bpy.data.cameras.new(name="Camera")
    cam_data.lens = focal
    cam_obj = bpy.data.objects.new(name="Camera", object_data=cam_data)
    bpy.context.collection.objects.link(cam_obj)
    bpy.context.scene.camera = cam_obj
    cam_obj.location = loc
    cam_obj.rotation_euler = rot
    return cam_obj

def make_material(name, base_color, roughness=0.3, metallic=0.1, emission_color=None, emission_strength=0.0):
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

def convert_to_webp(png_path, webp_path):
    try:
        img = Image.open(png_path)
        img.save(webp_path, "WEBP", quality=90)
        print(f"Converted {png_path} -> {webp_path}")
    except Exception as e:
        print(f"WebP conversion error: {e}")

# 1. FLOATING DISCORD CROWN (Pink/Magenta 3D Crown as in reference image)
def create_floating_crown():
    scene = reset_scene()
    setup_lights()
    create_camera(loc=(0, -6.5, 0.9), rot=(math.radians(82), 0, math.radians(-10)), focal=42)

    crown_pink_mat = make_material("CrownPink", (0.92, 0.28, 0.70, 1.0), roughness=0.22, metallic=0.25)
    crown_gold_mat = make_material("CrownGold", (1.0, 0.82, 0.25, 1.0), roughness=0.18, metallic=0.7)
    gem_cyan_mat = make_material("GemCyan", (0.1, 0.9, 1.0, 1.0), roughness=0.1, emission_color=(0.1, 0.9, 1.0, 1.0), emission_strength=2.0)

    # Crown Base Ring
    bpy.ops.mesh.primitive_cylinder_add(radius=1.1, depth=0.35, vertices=32, location=(0, 0, 0))
    base_ring = bpy.context.active_object
    base_ring.data.materials.append(crown_gold_mat)
    bpy.ops.object.shade_smooth()

    # Crown Body (Cone taper)
    bpy.ops.mesh.primitive_cone_add(radius1=1.12, radius2=1.35, depth=0.8, vertices=32, location=(0, 0, 0.45))
    body = bpy.context.active_object
    body.data.materials.append(crown_pink_mat)
    bpy.ops.object.shade_smooth()

    # Crown Spikes (5 points)
    num_spikes = 5
    for i in range(num_spikes):
        angle = i * (2 * math.pi / num_spikes)
        sx = math.cos(angle) * 1.32
        sy = math.sin(angle) * 1.32
        bpy.ops.mesh.primitive_cone_add(radius1=0.22, radius2=0.04, depth=0.6, vertices=16, location=(sx, sy, 1.05))
        spike = bpy.context.active_object
        spike.rotation_euler = (math.radians(10) * math.sin(angle), -math.radians(10) * math.cos(angle), angle)
        spike.data.materials.append(crown_pink_mat)
        bpy.ops.object.shade_smooth()

        # Jewel at each spike tip
        bpy.ops.mesh.primitive_uv_sphere_add(radius=0.09, location=(sx * 1.02, sy * 1.02, 1.38))
        jewel = bpy.context.active_object
        jewel.data.materials.append(gem_cyan_mat)
        bpy.ops.object.shade_smooth()

    # Front center emblem gem
    bpy.ops.mesh.primitive_uv_sphere_add(radius=0.18, location=(0, -1.25, 0.45))
    center_gem = bpy.context.active_object
    center_gem.scale = (1.0, 0.5, 1.3)
    bpy.ops.object.transform_apply(scale=True)
    center_gem.data.materials.append(crown_gold_mat)
    bpy.ops.object.shade_smooth()

    png_path = os.path.join(OUTPUT_DIR, "discord_crown.png")
    scene.render.filepath = png_path
    bpy.ops.render.render(write_still=True)
    print(f"Rendered {png_path}")
    convert_to_webp(png_path, os.path.join(OUTPUT_DIR, "discord_crown.webp"))

# 2. FLOATING DISCORD TROPHY (Golden/Purple Cup in reference background)
def create_floating_trophy():
    scene = reset_scene()
    setup_lights()
    create_camera(loc=(0, -6.6, 0.4), rot=(math.radians(85), 0, math.radians(12)), focal=44)

    gold_mat = make_material("TrophyGold", (1.0, 0.78, 0.22, 1.0), roughness=0.15, metallic=0.85)
    purple_mat = make_material("TrophyPurple", (0.45, 0.32, 0.88, 1.0), roughness=0.25, metallic=0.2)
    accent_star_mat = make_material("TrophyStar", (1.0, 0.95, 0.4, 1.0), roughness=0.1, emission_color=(1.0, 0.9, 0.3, 1.0), emission_strength=2.5)

    # Base Pedestal
    bpy.ops.mesh.primitive_cylinder_add(radius=0.9, depth=0.3, vertices=32, location=(0, 0, -0.7))
    base = bpy.context.active_object
    base.data.materials.append(purple_mat)
    bpy.ops.object.shade_smooth()

    # Stem
    bpy.ops.mesh.primitive_cylinder_add(radius=0.25, depth=0.6, vertices=24, location=(0, 0, -0.3))
    stem = bpy.context.active_object
    stem.data.materials.append(gold_mat)
    bpy.ops.object.shade_smooth()

    # Cup Bowl
    bpy.ops.mesh.primitive_cone_add(radius1=0.35, radius2=1.1, depth=1.1, vertices=32, location=(0, 0, 0.45))
    cup = bpy.context.active_object
    cup.data.materials.append(gold_mat)
    bpy.ops.object.shade_smooth()

    # Rim
    bpy.ops.mesh.primitive_torus_add(major_radius=1.1, minor_radius=0.08, location=(0, 0, 1.0))
    rim = bpy.context.active_object
    rim.data.materials.append(gold_mat)
    bpy.ops.object.shade_smooth()

    # Handles (Left & Right)
    for sign in [-1, 1]:
        bpy.ops.mesh.primitive_torus_add(major_radius=0.45, minor_radius=0.08, location=(sign * 1.25, 0, 0.5))
        handle = bpy.context.active_object
        handle.rotation_euler = (0, math.radians(90), 0)
        handle.scale = (1.2, 0.8, 1.0)
        bpy.ops.object.transform_apply(scale=True)
        handle.data.materials.append(gold_mat)
        bpy.ops.object.shade_smooth()

    # Star Badge on Front
    bpy.ops.mesh.primitive_cylinder_add(radius=0.28, depth=0.08, vertices=5, location=(0, -1.02, 0.55))
    star = bpy.context.active_object
    star.rotation_euler = (math.radians(90), 0, math.radians(18))
    star.data.materials.append(accent_star_mat)
    bpy.ops.object.shade_smooth()

    png_path = os.path.join(OUTPUT_DIR, "discord_trophy.png")
    scene.render.filepath = png_path
    bpy.ops.render.render(write_still=True)
    print(f"Rendered {png_path}")
    convert_to_webp(png_path, os.path.join(OUTPUT_DIR, "discord_trophy.webp"))

# 3. FLOATING DISCORD GAMEPAD (Stylized Blurple & Neon Controller)
def create_floating_gamepad():
    scene = reset_scene()
    setup_lights()
    create_camera(loc=(0, -6.5, 0.8), rot=(math.radians(72), 0, math.radians(-12)), focal=45)

    body_mat = make_material("GamepadBody", (0.345, 0.396, 0.949, 1.0), roughness=0.25, metallic=0.15)
    button_cyan_mat = make_material("BtnCyan", (0.1, 0.9, 1.0, 1.0), roughness=0.1, emission_color=(0.1, 0.9, 1.0, 1.0), emission_strength=2.0)
    button_pink_mat = make_material("BtnPink", (0.95, 0.25, 0.65, 1.0), roughness=0.1, emission_color=(0.95, 0.25, 0.65, 1.0), emission_strength=2.0)
    stick_dark_mat = make_material("StickDark", (0.1, 0.12, 0.2, 1.0), roughness=0.3, metallic=0.3)

    # Main Body Pill
    bpy.ops.mesh.primitive_cube_add(size=1.0, location=(0, 0, 0))
    pad = bpy.context.active_object
    pad.scale = (1.7, 0.9, 0.42)
    bpy.ops.object.transform_apply(scale=True)
    bevel = pad.modifiers.new(name="Bevel", type='BEVEL')
    bevel.width = 0.25
    bevel.segments = 6
    subsurf = pad.modifiers.new(name="Subsurf", type='SUBSURF')
    subsurf.levels = 2
    bpy.ops.object.shade_smooth()
    pad.data.materials.append(body_mat)

    # Grips (Left & Right angled)
    for sign in [-1, 1]:
        bpy.ops.mesh.primitive_cylinder_add(radius=0.4, depth=0.8, vertices=24, location=(sign * 1.5, 0.3, -0.2))
        grip = bpy.context.active_object
        grip.rotation_euler = (math.radians(-30), 0, sign * math.radians(-25))
        grip.data.materials.append(body_mat)
        bpy.ops.object.shade_smooth()

    # D-pad (Left)
    bpy.ops.mesh.primitive_cube_add(size=0.42, location=(-0.75, -0.2, 0.24))
    dpad1 = bpy.context.active_object
    dpad1.scale = (1.2, 0.35, 0.2)
    bpy.ops.object.transform_apply(scale=True)
    dpad1.data.materials.append(stick_dark_mat)
    bpy.ops.object.shade_smooth()

    bpy.ops.mesh.primitive_cube_add(size=0.42, location=(-0.75, -0.2, 0.24))
    dpad2 = bpy.context.active_object
    dpad2.scale = (0.35, 1.2, 0.2)
    bpy.ops.object.transform_apply(scale=True)
    dpad2.data.materials.append(stick_dark_mat)
    bpy.ops.object.shade_smooth()

    # Action Buttons (Right)
    btn_positions = [(0.75, -0.32), (0.95, -0.2), (0.75, -0.08), (0.55, -0.2)]
    for i, (bx, by) in enumerate(btn_positions):
        bpy.ops.mesh.primitive_cylinder_add(radius=0.09, depth=0.1, vertices=16, location=(bx, by, 0.26))
        btn = bpy.context.active_object
        btn.data.materials.append(button_cyan_mat if i % 2 == 0 else button_pink_mat)
        bpy.ops.object.shade_smooth()

    # Thumbsticks
    for sign in [-0.35, 0.35]:
        bpy.ops.mesh.primitive_cylinder_add(radius=0.22, depth=0.18, vertices=20, location=(sign, 0.15, 0.25))
        stick = bpy.context.active_object
        stick.data.materials.append(stick_dark_mat)
        bpy.ops.object.shade_smooth()

    png_path = os.path.join(OUTPUT_DIR, "discord_gamepad.png")
    scene.render.filepath = png_path
    bpy.ops.render.render(write_still=True)
    print(f"Rendered {png_path}")
    convert_to_webp(png_path, os.path.join(OUTPUT_DIR, "discord_gamepad.webp"))

if __name__ == "__main__":
    print("Generating properly framed Discord floating background motifs...")
    create_floating_crown()
    create_floating_trophy()
    create_floating_gamepad()
    print("All motifs successfully rendered and converted!")
