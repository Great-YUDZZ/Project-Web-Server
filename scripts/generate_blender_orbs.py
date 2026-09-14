import bpy
import os
import math
from PIL import Image

def render_orbs():
    techs = [
        {
            'id': 'laravel',
            'name': 'Laravel 13',
            'logo': '/tmp/tech_logos_clean/laravel.png',
            'color': (1.0, 0.18, 0.13, 1.0),
            'neon': (1.0, 0.25, 0.20, 1.0),
            'output_png': '/var/www/project_tkj_yuda2/public/images/orrery/laravel_orb.png',
            'output_webp': '/var/www/project_tkj_yuda2/public/images/orrery/laravel_orb.webp'
        },
        {
            'id': 'php',
            'name': 'PHP 8.4',
            'logo': '/tmp/tech_logos_clean/php.png',
            'color': (0.47, 0.48, 0.71, 1.0),
            'neon': (0.45, 0.50, 0.85, 1.0),
            'output_png': '/var/www/project_tkj_yuda2/public/images/orrery/php_orb.png',
            'output_webp': '/var/www/project_tkj_yuda2/public/images/orrery/php_orb.webp'
        },
        {
            'id': 'tailwind',
            'name': 'Tailwind CSS',
            'logo': '/tmp/tech_logos_clean/tailwind.png',
            'color': (0.02, 0.71, 0.83, 1.0),
            'neon': (0.05, 0.80, 0.95, 1.0),
            'output_png': '/var/www/project_tkj_yuda2/public/images/orrery/tailwind_orb.png',
            'output_webp': '/var/www/project_tkj_yuda2/public/images/orrery/tailwind_orb.webp'
        },
        {
            'id': 'vite',
            'name': 'Vite',
            'logo': '/tmp/tech_logos_clean/vite.png',
            'color': (0.39, 0.42, 1.0, 1.0),
            'neon': (0.55, 0.45, 1.0, 1.0),
            'output_png': '/var/www/project_tkj_yuda2/public/images/orrery/vite_orb.png',
            'output_webp': '/var/www/project_tkj_yuda2/public/images/orrery/vite_orb.webp'
        },
        {
            'id': 'nginx',
            'name': 'Nginx 1.26',
            'logo': '/tmp/tech_logos_clean/nginx.png',
            'color': (0.0, 0.59, 0.22, 1.0),
            'neon': (0.10, 0.80, 0.35, 1.0),
            'output_png': '/var/www/project_tkj_yuda2/public/images/orrery/nginx_orb.png',
            'output_webp': '/var/www/project_tkj_yuda2/public/images/orrery/nginx_orb.webp'
        },
        {
            'id': 'mariadb',
            'name': 'MariaDB 11.8',
            'logo': '/tmp/tech_logos_clean/mariadb.png',
            'color': (0.0, 0.52, 0.78, 1.0),
            'neon': (0.05, 0.65, 0.90, 1.0),
            'output_png': '/var/www/project_tkj_yuda2/public/images/orrery/mariadb_orb.png',
            'output_webp': '/var/www/project_tkj_yuda2/public/images/orrery/mariadb_orb.webp'
        },
        {
            'id': 'javascript',
            'name': 'JavaScript',
            'logo': '/tmp/tech_logos_clean/javascript.png',
            'color': (0.97, 0.87, 0.12, 1.0),
            'neon': (0.98, 0.88, 0.20, 1.0),
            'output_png': '/var/www/project_tkj_yuda2/public/images/orrery/javascript_orb.png',
            'output_webp': '/var/www/project_tkj_yuda2/public/images/orrery/javascript_orb.webp'
        },
        {
            'id': 'debian',
            'name': 'Debian 13',
            'logo': '/tmp/tech_logos_clean/debian.png',
            'color': (0.84, 0.04, 0.33, 1.0),
            'neon': (0.95, 0.10, 0.35, 1.0),
            'output_png': '/var/www/project_tkj_yuda2/public/images/orrery/debian_orb.png',
            'output_webp': '/var/www/project_tkj_yuda2/public/images/orrery/debian_orb.webp'
        },
        {
            'id': 'core_central',
            'name': 'Solar Engine Core',
            'logo': '/var/www/project_tkj_yuda2/public/images/logo.png',
            'color': (0.15, 0.55, 1.0, 1.0),
            'neon': (0.10, 0.80, 0.95, 1.0),
            'output_png': '/var/www/project_tkj_yuda2/public/images/orrery/core_central_orb.png',
            'output_webp': '/var/www/project_tkj_yuda2/public/images/orrery/core_central_orb.webp'
        }
    ]

    os.makedirs('/var/www/project_tkj_yuda2/public/images/orrery', exist_ok=True)

    for tech in techs:
        print(f"=== Rendering Luminous Pearl 3D Orb: {tech['name']} ===")
        bpy.ops.wm.read_factory_settings(use_empty=True)
        scene = bpy.context.scene
        scene.render.engine = 'CYCLES'
        scene.cycles.use_denoising = False
        scene.cycles.samples = 40
        scene.render.film_transparent = True
        scene.render.resolution_x = 512
        scene.render.resolution_y = 512
        scene.render.filepath = tech['output_png']

        # 0. Bright Studio World Environment (Gives chrome and ceramic bright white/silver specular reflections)
        world = bpy.data.worlds.new('StudioWorld')
        world.use_nodes = True
        bg = world.node_tree.nodes.get('Background')
        bg.inputs['Color'].default_value = (0.92, 0.95, 1.0, 1.0)
        bg.inputs['Strength'].default_value = 0.85
        scene.world = world

        # Camera setup
        cam_data = bpy.data.cameras.new('Camera')
        cam_data.lens = 75
        cam_obj = bpy.data.objects.new('Camera', cam_data)
        scene.collection.objects.link(cam_obj)
        scene.camera = cam_obj
        cam_obj.location = (0, -5.2, 0.3)
        cam_obj.rotation_euler = (math.radians(88), 0, 0)

        # Lighting: 3-point bright studio lighting
        # Key light (pure white)
        l1_data = bpy.data.lights.new(name='Key', type='POINT')
        l1_data.energy = 900
        l1_data.color = (1.0, 1.0, 1.0)
        l1 = bpy.data.objects.new('Key', l1_data)
        scene.collection.objects.link(l1)
        l1.location = (2.5, -3.5, 3.5)

        # Rim light (accent crisp specular)
        l2_data = bpy.data.lights.new(name='Rim', type='POINT')
        l2_data.energy = 950
        l2_data.color = (1.0, 0.96, 0.96)
        l2 = bpy.data.objects.new('Rim', l2_data)
        scene.collection.objects.link(l2)
        l2.location = (-2.5, 2.5, 3.0)

        # Fill light (soft ambient bounce)
        l3_data = bpy.data.lights.new(name='Fill', type='POINT')
        l3_data.energy = 450
        l3_data.color = (0.94, 0.97, 1.0)
        l3 = bpy.data.objects.new('Fill', l3_data)
        scene.collection.objects.link(l3)
        l3.location = (-2.5, -3.0, -1.0)

        # 1. Pearl White Glossy Ceramic Core Sphere (Never dark or black)
        bpy.ops.mesh.primitive_uv_sphere_add(segments=64, ring_count=32, radius=1.0, location=(0, 0, 0))
        sphere = bpy.context.active_object
        bpy.ops.object.shade_smooth()
        s_mat = bpy.data.materials.new(name='PearlMat')
        s_mat.use_nodes = True
        p = s_mat.node_tree.nodes.get('Principled BSDF')
        p.inputs['Base Color'].default_value = (0.98, 0.99, 1.0, 1.0)
        p.inputs['Metallic'].default_value = 0.04
        p.inputs['Roughness'].default_value = 0.08
        p.inputs['Coat Weight'].default_value = 1.0
        p.inputs['Coat Roughness'].default_value = 0.02
        sphere.data.materials.append(s_mat)

        # 2. Glowing Neon Equator Trench (Tech Brand Color)
        bpy.ops.mesh.primitive_torus_add(major_radius=1.02, minor_radius=0.035, major_segments=64, minor_segments=16)
        glow_ring = bpy.context.active_object
        glow_ring.rotation_euler = (math.radians(90), 0, 0)
        bpy.ops.object.shade_smooth()
        g_mat = bpy.data.materials.new(name='GlowMat')
        g_mat.use_nodes = True
        em = g_mat.node_tree.nodes.new('ShaderNodeEmission')
        em.inputs['Color'].default_value = tech['color']
        em.inputs['Strength'].default_value = 5.5
        out = g_mat.node_tree.nodes.get('Material Output')
        g_mat.node_tree.links.new(em.outputs['Emission'], out.inputs['Surface'])
        glow_ring.data.materials.append(g_mat)

        # 3. Front Tech Emblem Faceplate with Crisp Logo (Zero Shadow Casting)
        bpy.ops.mesh.primitive_plane_add(size=1.1, location=(0, -1.005, 0))
        logo_plane = bpy.context.active_object
        logo_plane.rotation_euler = (math.radians(90), 0, 0)
        logo_plane.visible_shadow = False  # Critical: Prevent square shadow on pearl sphere

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
        em_logo = mn.new('ShaderNodeEmission')
        em_logo.inputs['Strength'].default_value = 3.2
        ln.new(tex.outputs['Color'], em_logo.inputs['Color'])
        tr = mn.new('ShaderNodeBsdfTransparent')
        mix = mn.new('ShaderNodeMixShader')
        ln.new(tex.outputs['Alpha'], mix.inputs['Fac'])
        ln.new(tr.outputs['BSDF'], mix.inputs[1])
        ln.new(em_logo.outputs['Emission'], mix.inputs[2])
        mout = mn.new('ShaderNodeOutputMaterial')
        ln.new(mix.outputs['Shader'], mout.inputs['Surface'])
        logo_plane.data.materials.append(lm)

        # 4. Polished Bright Chrome / Platinum Gyro Ring 1 (Ultra-Bright Silver Specular)
        bpy.ops.mesh.primitive_torus_add(major_radius=1.45, minor_radius=0.032, major_segments=64, minor_segments=16)
        r1 = bpy.context.active_object
        r1.rotation_euler = (math.radians(18), math.radians(35), 0)
        bpy.ops.object.shade_smooth()
        r1_mat = bpy.data.materials.new(name='ChromeRing1')
        r1_mat.use_nodes = True
        r1_p = r1_mat.node_tree.nodes.get('Principled BSDF')
        r1_p.inputs['Base Color'].default_value = (0.96, 0.98, 1.0, 1.0)
        r1_p.inputs['Metallic'].default_value = 1.0
        r1_p.inputs['Roughness'].default_value = 0.05
        r1_p.inputs['Coat Weight'].default_value = 1.0
        r1.data.materials.append(r1_mat)

        # 5. Glowing Neon Outer Accent Gyro Ring 2 (Vibrant Tech Accent)
        bpy.ops.mesh.primitive_torus_add(major_radius=1.65, minor_radius=0.02, major_segments=64, minor_segments=16)
        r2 = bpy.context.active_object
        r2.rotation_euler = (math.radians(-25), math.radians(15), 0)
        bpy.ops.object.shade_smooth()
        r2_mat = bpy.data.materials.new(name='NeonRing2')
        r2_mat.use_nodes = True
        r2_em = r2_mat.node_tree.nodes.new('ShaderNodeEmission')
        r2_em.inputs['Color'].default_value = tech['neon']
        r2_em.inputs['Strength'].default_value = 4.5
        r2_out = r2_mat.node_tree.nodes.get('Material Output')
        r2_mat.node_tree.links.new(r2_em.outputs['Emission'], r2_out.inputs['Surface'])
        r2.data.materials.append(r2_mat)

        # Render PNG still
        bpy.ops.render.render(write_still=True)
        print(f"Generated PNG: {tech['output_png']}")

        # Convert to WebP with PIL
        try:
            with Image.open(tech['output_png']) as img:
                img.save(tech['output_webp'], 'WEBP', quality=94, method=6)
            print(f"Converted to WebP: {tech['output_webp']}")
        except Exception as e:
            print(f"WebP conversion failed for {tech['id']}: {e}")

    print("=== All 9 3D Pearl Orbs rendered and converted successfully! ===")

if __name__ == '__main__':
    render_orbs()
