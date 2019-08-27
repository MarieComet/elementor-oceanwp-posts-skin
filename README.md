# Elementor Ocean WP Posts Skin
WordPress plugin that add a new skin to Elementor Pro Posts and Archives widgets which display OceanWP post template part style

## Prerequistes :
- Elementor Pro activated
- OceanWP or OceanWP child theme activated

## Installation instructions
- Upload and activate Elementor Ocean WP Posts Skin plugin
- Edit a Post or Archive Posts widget in Elementor, you will see a new skin called "Theme", which display posts in the OceanWP style.
There is no style options for this skin : it display OceanWP style, which is set in the Customizer.

## Good to know
The new skin simply use `get_template_part( 'partials/entry/layout' );`, which is located inside OceanWP theme OR OceanWP child theme.
