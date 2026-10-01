# PokéSave Editor v5

Browser-based Pokémon save editor based on PKHeX Everywhere.

This version keeps the original Plugins, Analytics, and Save navigation visible throughout the editor while using the /saveeditor/ deployment base path.

Builds are produced by GitHub Actions and the published `wwwroot` is ready for static hosting such as DirectAdmin.

## v11 build fix
The GitHub Actions workflow builds the upstream React page bundle and verifies `react/pages.js` is present in the published static site.
