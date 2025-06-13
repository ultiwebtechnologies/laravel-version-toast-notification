# Introduction
A lightweight, zero-dependency Laravel package that automatically notifies your users in the browser whenever you deploy a new release—no extra release manager or email blasts required.


Releasing new versions and making sure your users know about them can quickly become a blocker—especially for startups without a formal release process or dedicated release manager. Emails are slow, error-prone, and add overhead to every deploy.

**This package streamlines the entire flow:**

1. **CI/CD writes a version file**  
   On every commit (or tag), your GitHub Actions (or any CI) grab the latest Git tag and short commit SHA, then write a simple `public/build.version.json`:

   ```json
   {
     "tag": "v1.2.3",
     "commit": "g5f3e2c1"
   }

2. **Laravel exposes the version**
At runtime, the package reads that JSON and makes tag and commit available in your Blade views.

3. **Browser toast on change**
A tiny JavaScript snippet compares the current version (embedded in your page) against the file in public/. If there’s a mismatch, it pops a Bootstrap toast prompting the user to refresh.

# Features
- 🔄 Automatic version bump via CI on every push or tag
- ⚡ Zero-config Blade integration—just include a single partial
- 🍞 Bootstrap-powered toast (configurable position, styling)
- 📦 Composer-ready—one composer require and an install command

# Installation
1. Require the package via Composer:
```
composer require ultiwebtechnologies/laravel-version-toast-notification
```

2. Publish the assets and scaffold your layout:
```
php artisan version-toast:install
```

3. In your main layout (e.g. resources/views/layouts/app.blade.php), just before </body> add:

```
@include('vendor.version-toast.toast')```
<script src="/vendor/version-toast/js/version-toast.js"></script>
```

# GitHub Actions Snippet
Add this to your CI workflow (e.g. .github/workflows/deploy-dev.yml) to generate and commit public/build.version.json:

```
jobs:
  deploy-dev:
    runs-on: ubuntu-latest

    steps:
      # 1️⃣ Checkout with tags (shallow history + tags only)
      - name: Checkout repo
        uses: actions/checkout@v3
        with:
          fetch-depth: 0
          persist-credentials: true

      # 2️⃣ Determine version & commit
      - name: Gather version info
        id: vars
        run: |
          if git describe --tags --abbrev=0 >/dev/null 2>&1; then
            TAG=$(git describe --tags --abbrev=0)
          else
            TAG="0.0.0"
          fi
          COMMIT=$(git rev-parse --short HEAD)
          echo "tag=$TAG"      >> $GITHUB_OUTPUT
          echo "commit=$COMMIT" >> $GITHUB_OUTPUT

      # 3️⃣ Write build.version.json
      - name: Write version file to public/
        run: |
          mkdir -p public
          cat > public/build.version.json <<EOF
          {
            "tag": "${{ steps.vars.outputs.tag }}",
            "commit": "g${{ steps.vars.outputs.commit }}"
          }
          EOF

      # 4️⃣ Commit & push only if changed
      - name: Commit version file
        run: |
          git config user.name  "github-actions[bot]"
          git config user.email "github-actions[bot]@users.noreply.github.com"
          git add public/build.version.json
          if git diff --cached --quiet; then
            echo "No version changes; skipping commit."
          else
            git commit -m "ci: bump build.version to ${{ steps.vars.outputs.tag }}.g${{ steps.vars.outputs.commit }}"
            git push origin env/dev
          fi

```

# Configuration
You can publish and tweak the default config:
```
php artisan vendor:publish --tag=version-toast
```
- version_file: filename in public/ (default: build.version.json)

- poll_interval: how often (in seconds) the browser checks for updates (default: 300)

# License
MIT © ULTIweb Technologies
