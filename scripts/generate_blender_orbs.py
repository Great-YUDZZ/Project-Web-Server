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

def render_orbs():
    techs = [
        {
            'id': 'laravel',
            'name': 'Laravel 13',
            'logo': '/var/www/project_tkj_yuda2/public/images/tech_logos/laravel_emblem.png',
            'base_hex': '#FF2D20',
            'neon_hex': '#FF4D3D',
            'is_dark_logo': False,
            'output_png': '/var/www/project_tkj_yuda2/public/images/orrery/laravel_orb.png',
            'output_webp': '/var/www/project_tkj_yuda2/public/images/orrery/laravel_orb.webp'
        },
        {
            'id': 'php',
            'name': 'PHP 8.4',
            'logo': '/var/www/project_tkj_yuda2/public/images/tech_logos/php_emblem.png',
            'base_hex': '#4F5D95',
            'neon_hex': '#777BB4',
            'is_dark_logo': False,
            'output_png': '/var/www/project_tkj_yuda2/public/images/orrery/php_orb.png',
            'output_webp': '/var/www/project_tkj_yuda2/public/images/orrery/php_orb.webp'
        },
        {
            'id': 'tailwind',
            'name': 'Tailwind CSS',
            'logo': '/var/www/project_tkj_yuda2/public/images/tech_logos/tailwind_emblem.png',
            'base_hex': '#06B6D4',
            'neon_hex': '#38BDF8',
            'is_dark_logo': False,
            'output_png': '/var/www/project_tkj_yuda2/public/images/orrery/tailwind_orb.png',
            'output_webp': '/var/www/project_tkj_yuda2/public/images/orrery/tailwind_orb.webp'
        },
        {
            'id': 'vite',
            'name': 'Vite',
            'logo': '/var/www/project_tkj_yuda2/public/images/tech_logos/vite_emblem.png',
            'base_hex': '#4C1D95',
            'neon_hex': '#8B5CF6',
            'is_dark_logo': False,
            'output_png': '/var/www/project_tkj_yuda2/public/images/orrery/vite_orb.png',
            'output_webp': '/var/www/project_tkj_yuda2/public/images/orrery/vite_orb.webp'
        },
        {
            'id': 'nginx',
            'name': 'Nginx 1.26',
            'logo': '/var/www/project_tkj_yuda2/public/images/tech_logos/nginx_emblem.png',
            'base_hex': '#009639',
            'neon_hex': '#10B981',
            'is_dark_logo': False,
            'output_png': '/var/www/project_tkj_yuda2/public/images/orrery/nginx_orb.png',
            'output_webp': '/var/www/project_tkj_yuda2/public/images/orrery/nginx_orb.webp'
        },
        {
            'id': 'mariadb',
            'name': 'MariaDB 11.8',
            'logo': '/var/www/project_tkj_yuda2/public/images/tech_logos/mariadb_emblem.png',
            'base_hex': '#00758F',
            'neon_hex': '#00A3C4',
            'is_dark_logo': False,
            'output_png': '/var/www/project_tkj_yuda2/public/images/orrery/mariadb_orb.png',
            'output_webp': '/var/www/project_tkj_yuda2/public/images/orrery/mariadb_orb.webp'
        },
        {
            'id': 'javascript',
            'name': 'JavaScript',
            'logo': '/var/www/project_tkj_yuda2/public/images/tech_logos/javascript_emblem.png',
            'base_hex': '#F7DF1E',
            'neon_hex': '#FFE600',
            'is_dark_logo': True,
            'output_png': '/var/www/project_tkj_yuda2/public/images/orrery/javascript_orb.png',
            'output_webp': '/var/www/project_tkj_yuda2/public/images/orrery/javascript_orb.webp'
        },
        {
            'id': 'debian',
            'name': 'Debian 13',
            'logo': '/var/www/project_tkj_yuda2/public/images/tech_logos/debian_emblem.png',
            'base_hex': '#D70A53',
            'neon_hex': '#FF2A7A',
            'is_dark_logo': False,
            'output_png': '/var/www/project_tkj_yuda2/public/images/orrery/debian_orb.png',
            'output_webp': '/var/www/project_tkj_yuda2/public/images/orrery/debian_orb.webp'
        },
        {
            'id': 'core_central',
            'name': 'Solar Engine Core',
            'logo': '/var/www/project_tkj_yuda2/public/images/tech_logos/core_emblem.png',
            'base_hex': '#1D4ED8',
            'neon_hex': '#38BDF8',
            'is_dark_logo': False,
            'output_png': '/var/www/project_tkj_yuda2/public/images/orrery/core_central_orb.png',
            'output_webp': '/var/www/project_tkj_yuda2/public/images/orrery/core_central_orb.webp'
        }
    ]

    os.makedirs('/var/www/project_tkj_yuda2/public/images/orrery', exist_ok=True)

    for tech in techs:
        print(f"=== Rendering 3D Vibrant Brand Planet: {tech['name']} ===")
        bpy.ops.wm.read_factory_settings(use_empty=True)
        scene = bpy.context.scene
        scene.render.engine = 'CYCLES'
        scene.cycles.use_denoising = False
        scene.cycles.samples = 48
        scene.render.film_transparent = True
        scene.render.resolution_x = 512
        scene.render.resolution_y = 512
        scene.render.filepath = tech['output_png']

        # 0. Color Management: Standard view transform (true brand color vibrancy, zero bleaching)
        scene.view_settings.view_transform = 'Standard'

        # Studio World: dark subtle studio void so film transparency and rich brand saturations stay true
        world = bpy.data.worlds.new('StudioWorld')
        world.use_nodes = True
        bg = world.node_tree.nodes.get('Background')
        bg.inputs['Color'].default_value = (0.05, 0.05, 0.08, 1.0)
        bg.inputs['Strength'].default_value = 0.1
        scene.world = world

        # Camera setup: 50mm, distance -5.2m (Closer, larger, grander view with safe ~50px margins on all sides)
        cam_data = bpy.data.cameras.new('Camera')
        cam_data.lens = 50
        cam_obj = bpy.data.objects.new('Camera', cam_data)
        scene.collection.objects.link(cam_obj)
        scene.camera = cam_obj
        cam_obj.location = (0, -5.2, 0.30)
        cam_obj.rotation_euler = (math.radians(87.5), 0, 0)

        # 4-Point Studio Lighting for strong, genuine 3D spherical depth, specular curvature & metallic gleam
        # Key light (crisp key from top-right)
        l1 = bpy.data.objects.new('Key', bpy.data.lights.new('Key', 'POINT'))
        l1.data.energy = 450
        l1.data.color = (1.0, 0.98, 0.96)
        l1.location = (3.2, -4.2, 3.2)
        scene.collection.objects.link(l1)

        # Rim light (sharp specular rim from back-left outlining spherical silhouette)
        l2 = bpy.data.objects.new('Rim', bpy.data.lights.new('Rim', 'POINT'))
        l2.data.energy = 650
        l2.data.color = (1.0, 1.0, 1.0)
        l2.location = (-3.2, 3.2, 3.0)
        scene.collection.objects.link(l2)

        # Soft Front Fill (subtle bounce from bottom-left)
        l3 = bpy.data.objects.new('Fill', bpy.data.lights.new('Fill', 'POINT'))
        l3.data.energy = 120
        l3.data.color = (1.0, 1.0, 1.0)
        l3.location = (-1.8, -3.5, 0.5)
        scene.collection.objects.link(l3)

        # Bottom Up-light (illuminates underside of chrome gyro ring)
        l4 = bpy.data.objects.new('UpLight', bpy.data.lights.new('UpLight', 'POINT'))
        l4.data.energy = 90
        l4.data.color = (0.92, 0.96, 1.0)
        l4.location = (0, -2.0, -3.0)
        scene.collection.objects.link(l4)

        # 1. Body Sphere: Rich Vibrant 3D Brand Planet with glossy clearcoat and tactile depth
        bpy.ops.mesh.primitive_uv_sphere_add(segments=64, ring_count=32, radius=1.0, location=(0, 0, 0))
        sphere = bpy.context.active_object
        bpy.ops.object.shade_smooth()
        s_mat = bpy.data.materials.new(name='SphereMat')
        s_mat.use_nodes = True
        p = s_mat.node_tree.nodes.get('Principled BSDF')
        p.inputs['Base Color'].default_value = hex_to_linear(tech['base_hex'])
        p.inputs['Metallic'].default_value = 0.08
        p.inputs['Roughness'].default_value = 0.18
        p.inputs['Coat Weight'].default_value = 1.0
        p.inputs['Coat Roughness'].default_value = 0.04
        sphere.data.materials.append(s_mat)

        # 2. Glowing Equator Trench (Tech Brand Signature Neon Color)
        bpy.ops.mesh.primitive_torus_add(major_radius=1.018, minor_radius=0.035, major_segments=64, minor_segments=16)
        glow_ring = bpy.context.active_object
        glow_ring.rotation_euler = (math.radians(90), 0, 0)
        bpy.ops.object.shade_smooth()
        g_mat = bpy.data.materials.new(name='GlowMat')
        g_mat.use_nodes = True
        em = g_mat.node_tree.nodes.new('ShaderNodeEmission')
        em.inputs['Color'].default_value = hex_to_linear(tech['neon_hex'])
        em.inputs['Strength'].default_value = 6.0
        out = g_mat.node_tree.nodes.get('Material Output')
        g_mat.node_tree.links.new(em.outputs['Emission'], out.inputs['Surface'])
        glow_ring.data.materials.append(g_mat)

        # 3. Front Tech Emblem: BOLD & PROMINENT (Size = 1.15 - fills the sphere face)
        bpy.ops.mesh.primitive_plane_add(size=1.15, location=(0, -1.006, 0))
        logo_plane = bpy.context.active_object
        logo_plane.rotation_euler = (math.radians(90), 0, 0)
        logo_plane.visible_shadow = False

        lm = bpy.data.materials.new(name='LogoMat')
        lm.use_nodes = True
        mn = lm.node_tree.nodes
        mn.clear()
        ln = lm.node_tree.links
        tc = mn.new('ShaderNodeTexCoord')
        tex = mn.new('ShaderNodeTexImage')
        if os.path.exists(tech['logo']):
            tex.image = bpy.data.images.load(tech['logo'])
        tex.extension = 'CLIP'
        ln.new(tc.outputs['UV'], tex.inputs['Vector'])

        # Controlled emission shader: 100% exact brand color saturation, unbleached, high contrast
        em_logo = mn.new('ShaderNodeEmission')
        if tech['is_dark_logo']:
            em_logo.inputs['Strength'].default_value = 1.0
        else:
            em_logo.inputs['Strength'].default_value = 2.2
        ln.new(tex.outputs['Color'], em_logo.inputs['Color'])

        tr = mn.new('ShaderNodeBsdfTransparent')
        mix = mn.new('ShaderNodeMixShader')
        ln.new(tex.outputs['Alpha'], mix.inputs['Fac'])
        ln.new(tr.outputs['BSDF'], mix.inputs[1])
        ln.new(em_logo.outputs['Emission'], mix.inputs[2])

        mout = mn.new('ShaderNodeOutputMaterial')
        ln.new(mix.outputs['Shader'], mout.inputs['Surface'])
        logo_plane.data.materials.append(lm)

        # 4. Sculpted 3D Mirror Chrome Gyro Ring 1 (Radius 1.28, thickness 0.055)
        bpy.ops.mesh.primitive_torus_add(major_radius=1.28, minor_radius=0.055, major_segments=64, minor_segments=16)
        r1 = bpy.context.active_object
        r1.rotation_euler = (math.radians(18), math.radians(35), 0)
        bpy.ops.object.shade_smooth()
        r1_mat = bpy.data.materials.new(name='ChromeRing1')
        r1_mat.use_nodes = True
        r1_p = r1_mat.node_tree.nodes.get('Principled BSDF')
        r1_p.inputs['Base Color'].default_value = (0.95, 0.96, 0.98, 1.0)
        r1_p.inputs['Metallic'].default_value = 0.92
        r1_p.inputs['Roughness'].default_value = 0.08
        r1_p.inputs['Coat Weight'].default_value = 1.0
        r1.data.materials.append(r1_mat)

        # 5. Glowing Neon Outer Accent Gyro Ring 2 (Radius 1.44, thickness 0.040)
        bpy.ops.mesh.primitive_torus_add(major_radius=1.44, minor_radius=0.040, major_segments=64, minor_segments=16)
        r2 = bpy.context.active_object
        r2.rotation_euler = (math.radians(-24), math.radians(16), 0)
        bpy.ops.object.shade_smooth()
        r2_mat = bpy.data.materials.new(name='NeonRing2')
        r2_mat.use_nodes = True
        r2_em = r2_mat.node_tree.nodes.new('ShaderNodeEmission')
        r2_em.inputs['Color'].default_value = hex_to_linear(tech['neon_hex'])
        r2_em.inputs['Strength'].default_value = 5.0
        r2_out = r2_mat.node_tree.nodes.get('Material Output')
        r2_mat.node_tree.links.new(r2_em.outputs['Emission'], r2_out.inputs['Surface'])
        r2.data.materials.append(r2_mat)

        # Render PNG still
        bpy.ops.render.render(write_still=True)
        print(f"Generated PNG: {tech['output_png']}")

        # Convert to WebP with PIL
        try:
            with Image.open(tech['output_png']) as img:
                img.save(tech['output_webp'], 'WEBP', quality=95, method=6)
            print(f"Converted to WebP: {tech['output_webp']}")
        except Exception as e:
            print(f"WebP conversion failed for {tech['id']}: {e}")

    print("=== All 9 3D Tech Brand Planets rendered and converted successfully! ===")

if __name__ == '__main__':
    render_orbs()
