# PokéSave Editor

A branded web build of [PKHeX Everywhere](https://github.com/arleypadua/PKHeX.Everywhere).

## Important build design

The GitHub Actions workflow builds against the upstream PKHeX Everywhere repository and its compatible Git submodules. This avoids dependency mismatches caused by uploading Git submodules as ordinary ZIP folders.

The `custom/` directory contains the PokéSave Editor UI overlay used during the build.

## Deployment

GitHub Actions produces a `pokesave-editor-site` artifact containing the static Blazor WebAssembly website. Extract its contents directly into the DirectAdmin document root. `index.html` must be in the document root.

The included `.htaccess` provides SPA fallback routing for Apache/LiteSpeed hosting.

## License

PKHeX Everywhere is licensed under GPL-3.0-or-later. See `LICENSE` and the upstream repository for details.
