import bpy
import os
import math

def render_orbs():
    techs = [
        {
            'id': 'laravel',
            'name': 'Laravel 13',
            'logo': '/tmp/tech_logos_clean/laravel.png',
            'color': (1.0, 0.18, 0.13, 1.0),
            'ring1': (0.90, 0.92, 0.96, 1.0),
            'ring2': (1.0, 0.25, 0.2, 1.0),
            'output': '/var/www/project_tkj_yuda2/public/images/orrery/laravel_orb.png'
        },
        {
            'id': 'php',
            'name': 'PHP 8.4',
            'logo': '/tmp/tech_logos_clean/php.png',
            'color': (0.47, 0.48, 0.71, 1.0),
            'ring1': (0.92, 0.94, 0.98, 1.0),
            'ring2': (0.35, 0.45, 0.95, 1.0),
            'output': '/var/www/project_tkj_yuda2/public/images/orrery/php_orb.png'
        },
        {
            'id': 'tailwind',
            'name': 'Tailwind CSS',
            'logo': '/tmp/tech_logos_clean/tailwind.png',
            'color': (0.02, 0.71, 0.83, 1.0),
            'ring1': (0.95, 0.98, 1.0, 1.0),
            'ring2': (0.05, 0.80, 0.95, 1.0),
            'output': '/var/www/project_tkj_yuda2/public/images/orrery/tailwind_orb.png'
        },
        {
            'id': 'vite',
            'name': 'Vite',
            'logo': '/tmp/tech_logos_clean/vite.png',
            'color': (0.39, 0.42, 1.0, 1.0),
            'ring1': (0.90, 0.92, 0.96, 1.0),
            'ring2': (0.95, 0.75, 0.20, 1.0),
            'output': '/var/www/project_tkj_yuda2/public/images/orrery/vite_orb.png'
        },
        {
            'id': 'nginx',
            'name': 'Nginx 1.26',
            'logo': '/tmp/tech_logos_clean/nginx.png',
            'color': (0.0, 0.59, 0.22, 1.0),
            'ring1': (0.92, 0.94, 0.98, 1.0),
            'ring2': (0.05, 0.85, 0.35, 1.0),
            'output': '/var/www/project_tkj_yuda2/public/images/orrery/nginx_orb.png'
        },
        {
            'id': 'mariadb',
            'name': 'MariaDB 11.8',
            'logo': '/tmp/tech_logos_clean/mariadb.png',
            'color': (0.75, 0.54, 0.30, 1.0),
            'ring1': (0.95, 0.85, 0.50, 1.0),
            'ring2': (0.85, 0.45, 0.20, 1.0),
            'output': '/var/www/project_tkj_yuda2/public/images/orrery/mariadb_orb.png'
        },
        {
            'id': 'javascript',
            'name': 'JavaScript',
            'logo': '/tmp/tech_logos_clean/javascript.png',
            'color': (0.97, 0.87, 0.12, 1.0),
            'ring1': (0.98, 0.88, 0.25, 1.0),
            'ring2': (0.20, 0.22, 0.25, 1.0),
            'output': '/var/www/project_tkj_yuda2/public/images/orrery/javascript_orb.png'
        },
        {
            'id': 'debian',
            'name': 'Debian 13',
            'logo': '/tmp/tech_logos_clean/debian.png',
            'color': (0.84, 0.04, 0.33, 1.0),
            'ring1': (0.92, 0.94, 0.98, 1.0),
            'ring2': (0.95, 0.10, 0.35, 1.0),
            'output': '/var/www/project_tkj_yuda2/public/images/orrery/debian_orb.png'
        },
        {
            'id': 'core_central',
            'name': 'Solar Engine Core',
            'logo': '/var/www/project_tkj_yuda2/public/images/logo.png',
            'color': (0.15, 0.55, 1.0, 1.0),
            'ring1': (0.95, 0.98, 1.0, 1.0),
            'ring2': (0.10, 0.80, 0.95, 1.0),
            'output': '/var/www/project_tkj_yuda2/public/images/orrery/core_central_orb.png'
        }
    ]

    os.makedirs('/var/www/project_tkj_yuda2/public/images/orrery', exist_ok=True)

    for tech in techs:
        print(f"--- Rendering 3D Asset: {tech['name']} ---")
        bpy.ops.wm.read_factory_settings(use_empty=True)
        scene = bpy.context.scene
        scene.render.engine = 'CYCLES'
        scene.cycles.use_denoising = False
        scene.cycles.samples = 48
        scene.render.film_transparent = True
        scene.render.resolution_x = 512
        scene.render.resolution_y = 512
        scene.render.filepath = tech['output']

        # Camera setup
        cam_data = bpy.data.cameras.new('Camera')
        cam_data.lens = 75
        cam_obj = bpy.data.objects.new('Camera', cam_data)
        scene.collection.objects.link(cam_obj)
        scene.camera = cam_obj
        cam_obj.location = (0, -5.5, 0.4)
        cam_obj.rotation_euler = (math.radians(86), 0, 0)

        # Lighting setup
        # Key light (studio warm white)
        l1_data = bpy.data.lights.new(name='Key', type='POINT')
        l1_data.energy = 650
        l1_data.color = (1.0, 0.98, 0.95)
        l1 = bpy.data.objects.new('Key', l1_data)
        scene.collection.objects.link(l1)
        l1.location = (2.5, -3.5, 3.5)

        # Rim light (sharp edge highlight)
        l2_data = bpy.data.lights.new(name='Rim', type='POINT')
        l2_data.energy = 850
        l2_data.color = (0.75, 0.88, 1.0)
        l2 = bpy.data.objects.new('Rim', l2_data)
        scene.collection.objects.link(l2)
        l2.location = (-3.0, 3.0, 3.0)

        # Fill light (soft ambient bounce)
        l3_data = bpy.data.lights.new(name='Fill', type='POINT')
        l3_data.energy = 220
        l3_data.color = (0.9, 0.95, 1.0)
        l3 = bpy.data.objects.new('Fill', l3_data)
        scene.collection.objects.link(l3)
        l3.location = (-2.5, -3.0, -1.0)

        # 1. Dark Cybernetic Body Sphere (Deep reflective slate metallic)
        bpy.ops.mesh.primitive_uv_sphere_add(segments=64, ring_count=32, radius=1.0, location=(0, 0, 0))
        sphere = bpy.context.active_object
        bpy.ops.object.shade_smooth()
        s_mat = bpy.data.materials.new(name='SphereMat')
        s_mat.use_nodes = True
        p = s_mat.node_tree.nodes.get('Principled BSDF')
        p.inputs['Base Color'].default_value = (0.03, 0.05, 0.09, 1.0)
        p.inputs['Metallic'].default_value = 0.95
        p.inputs['Roughness'].default_value = 0.10
        p.inputs['Coat Weight'].default_value = 0.85
        sphere.data.materials.append(s_mat)

        # 2. Glowing Equatorial Ring / Trench
        bpy.ops.mesh.primitive_torus_add(major_radius=1.03, minor_radius=0.035, major_segments=64, minor_segments=16)
        glow_ring = bpy.context.active_object
        glow_ring.rotation_euler = (math.radians(90), 0, 0)
        bpy.ops.object.shade_smooth()
        g_mat = bpy.data.materials.new(name='GlowMat')
        g_mat.use_nodes = True
        gnodes = g_mat.node_tree.nodes
        gnodes.clear()
        em = gnodes.new('ShaderNodeEmission')
        em.inputs['Color'].default_value = tech['color']
        em.inputs['Strength'].default_value = 3.8
        gout = gnodes.new('ShaderNodeOutputMaterial')
        g_mat.node_tree.links.new(em.outputs['Emission'], gout.inputs['Surface'])
        glow_ring.data.materials.append(g_mat)

        # 3. Front Tech Emblem Faceplate with Logo
        bpy.ops.mesh.primitive_plane_add(size=1.02, location=(0, -1.01, 0))
        logo_plane = bpy.context.active_object
        logo_plane.rotation_euler = (math.radians(90), 0, 0)

        m_mat = bpy.data.materials.new(name='MedallionMat')
        m_mat.use_nodes = True
        mnodes = m_mat.node_tree.nodes
        mnodes.clear()
        links = m_mat.node_tree.links

        tex_coord = mnodes.new('ShaderNodeTexCoord')
        mapping = mnodes.new('ShaderNodeMapping')
        mapping.vector_type = 'POINT'
        links.new(tex_coord.outputs['UV'], mapping.inputs['Vector'])

        tex = mnodes.new('ShaderNodeTexImage')
        if os.path.exists(tech['logo']):
            tex.image = bpy.data.images.load(tech['logo'])
        tex.extension = 'CLIP'
        links.new(mapping.outputs['Vector'], tex.inputs['Vector'])

        logo_emission = mnodes.new('ShaderNodeEmission')
        logo_emission.inputs['Strength'].default_value = 3.2
        links.new(tex.outputs['Color'], logo_emission.inputs['Color'])

        transparent_bsdf = mnodes.new('ShaderNodeBsdfTransparent')
        mix = mnodes.new('ShaderNodeMixShader')
        links.new(tex.outputs['Alpha'], mix.inputs['Fac'])
        links.new(transparent_bsdf.outputs['BSDF'], mix.inputs[1])
        links.new(logo_emission.outputs['Emission'], mix.inputs[2])

        mout = mnodes.new('ShaderNodeOutputMaterial')
        links.new(mix.outputs['Shader'], mout.inputs['Surface'])
        logo_plane.data.materials.append(m_mat)

        # 4. Outer Metallic Gyro Ring 1 (Polished Chrome / Titanium)
        bpy.ops.mesh.primitive_torus_add(major_radius=1.45, minor_radius=0.042, major_segments=64, minor_segments=16)
        r1 = bpy.context.active_object
        r1.rotation_euler = (math.radians(24), math.radians(45), 0)
        bpy.ops.object.shade_smooth()
        r1_mat = bpy.data.materials.new(name='R1Mat')
        r1_mat.use_nodes = True
        r1_p = r1_mat.node_tree.nodes.get('Principled BSDF')
        r1_p.inputs['Base Color'].default_value = tech['ring1']
        r1_p.inputs['Metallic'].default_value = 0.98
        r1_p.inputs['Roughness'].default_value = 0.10
        r1.data.materials.append(r1_mat)

        # 5. Outer Metallic Gyro Ring 2 (Anodized Tech Accent)
        bpy.ops.mesh.primitive_torus_add(major_radius=1.65, minor_radius=0.026, major_segments=64, minor_segments=16)
        r2 = bpy.context.active_object
        r2.rotation_euler = (math.radians(-32), math.radians(18), 0)
        bpy.ops.object.shade_smooth()
        r2_mat = bpy.data.materials.new(name='R2Mat')
        r2_mat.use_nodes = True
        r2_p = r2_mat.node_tree.nodes.get('Principled BSDF')
        r2_p.inputs['Base Color'].default_value = tech['ring2']
        r2_p.inputs['Metallic'].default_value = 0.90
        r2_p.inputs['Roughness'].default_value = 0.18
        r2.data.materials.append(r2_mat)

        # Render and write still
        bpy.ops.render.render(write_still=True)
        print(f"Successfully generated: {tech['output']}")

render_orbs()
