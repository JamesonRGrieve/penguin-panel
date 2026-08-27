# Penguin Panel

Penguin Panel is the web control panel for **Penguin** — a rebasable soft-fork of
[Pelican Panel](https://github.com/pelican-dev/panel) (Laravel 13 + Filament)
adapted so game/app servers run as **Proxmox LXC** (via Penguin Wings) instead of
Docker. AGPL-3.0-or-later (unchanged from upstream).

> Read the workspace `/home/jameson/Source/CLAUDE.md` and the user tenets first.
> PHP/Laravel follows this repo's own `pint.json` + `phpstan.neon`; TS/JS (vite
> assets) → `/home/jameson/Source/ai-prompts/typescript.md`. This file wins on
> Penguin specifics.

## Product shape

Penguin = **Penguin Panel** (this control plane, the **source of truth**) +
**Penguin Wings** (Go daemon that realizes servers as persistent Proxmox LXC via
embedded OpenTofu + the `bpg/proxmox` provider). Panel declares intent; Wings
makes it real. Penguin must **stand alone** for downstream operators — no NetBox,
no dependency on any private infra.

## What Penguin changes vs upstream Panel

Panel is largely backend-agnostic — it declares intent and Wings realizes it — so
the Docker→LXC shift touches it lightly:

- **Node target type.** A node points at a **Proxmox target** — the PVE node API
  now (PDM parked) — authenticated by an **API token**, replacing a
  Docker/Wings-on-host node.
- **Egg / image semantics.** An egg's Docker image reference becomes the **LXC's
  OCI base image** — Wings pulls it onto the node (PVE 9.1+ OCI application
  container) and the egg's install script + startup command run against it. The
  egg install contract is *adapted*, not the egg ecosystem discarded.
- **Allocations.** Map to a **per-LXC bridged IP**, not host port publishing.
- **Panel stays the source of truth** for servers; Wings holds the Tofu state
  (one workspace per server).

Keep these as a thin, isolated layer over upstream to preserve clean rebases.

## Soft-fork discipline

- `upstream` remote = `pelican-dev/panel`. Favor additive changes; avoid
  reformatting upstream files wholesale (pure rebase noise).
- License stays **AGPL-3.0** (`license` file — already AGPL upstream, no
  relicense needed). Add Penguin + Pelican attribution in the README during the
  rebrand; new source files carry an SPDX AGPL header.
- **Branding: text-only "Penguin", no image branding.** The bundled pelican logo
  and favicon (`public/pelican.svg` / `.ico`) are removed; brand logo/favicon are
  optional (`config('app.logo')` / `app.favicon`, unset by default → the text app
  name renders and no favicon ships). Egg rows fall back to *no* default icon when
  no `app.logo` is configured. Residual upstream *text*/path references to
  "pelican" in `.github/`, the `Dockerfile`s, and CLAUDE.md attribution are
  intentional (upstream project links / rebase-noise avoidance), not brand
  imagery.

## Quality gates (workspace §8)

Pint (format check), PHPStan (static analysis), PHPUnit (full suite) all green via
the pre-commit hook wired at bootstrap; coverage/typing ratchets never regress.
`--no-verify` forbidden without explicit authorization.

## Where Penguin work sits

~90% of the Docker→LXC work is in **Penguin Wings** (the container-runtime
rearchitecture: embedded Tofu, `bpg/proxmox`, persistent-LXC lifecycle from the
egg's OCI image, and PVE-native console/metrics — no in-container agent). Panel's
slice is the four bullets above. The companion `penguin-wings` repo's `CLAUDE.md`
holds the full daemon architecture and the phase plan.

## Phase 4 — Panel LXC support (design)

The Panel is **backend-agnostic**: a Node's connection fields (`fqdn`, `scheme`,
`daemon_token`, `daemon_listen`) point at a **Wings** instance, and the Proxmox
connection (endpoint/token/node/storage/image_storage/bridge) lives entirely in
**Wings' config** (`proxmox.*`), not the Panel. So the LXC backend works with **no
Panel schema change** for basic operation — the same server/egg/allocation model
drives it. Concrete changes, in priority order:

1. **Backend indicator on the Node (optional, informational).** A nullable
   `backend` enum (`docker`|`lxc`) so the UI can label a node and adjust
   backend-specific hints. Not required for function (Wings knows its own
   backend). Migration + Filament field + `fillable`/`casts`.
2. **Egg → OCI image (done in Wings, no Panel change).** The LXC backend uses the
   egg's `docker_image` directly as the container's OCI base — Wings pulls it
   (`EnsureOCIImage`, idempotent) and creates the LXC from it. No `lxc_template`
   field and no per-egg config is needed; the image carries its own runtime and
   non-root user.
3. **Allocation → static per-LXC IP (done, no Panel schema change).** The default
   allocation's `ip` becomes the CT's **static IP** in Wings' `serverToLXCSpec`
   (the gateway comes from Wings' `proxmox.gateway` config and a default prefix is
   applied; DHCP is the fallback when no gateway is set). So the existing
   `ip`/`port` allocation model is sufficient — no `gateway`/`cidr` columns were
   needed. **Caveat (ops):** on a shared/live bridge the allocation `ip` and the
   node `fqdn` must be genuinely-free addresses — a collision shows up indirectly
   as a Panel↔Wings `ConnectionException` or the game port never binding, not as a
   duplicate-IP error (see `penguin-wings/CLAUDE.md` → *Realization gotchas*).

**Launch semantics.** Creating a server installs it; pass `start_on_completion:
true` on the create (a standard Pelican application-API field) for Wings to boot
the run-script entrypoint straight into the game once install finishes — the
faithful "create and start" end-user flow.

**Implementation is gated on a Panel dev environment** (PHP + `composer install`
+ a database) to run the migrations, Filament forms, and PHPUnit suite — these
must not ship unverified. `php`/`composer`/`vendor/` are absent in the current
workspace.

## Open / parked decisions (shared)

- **Penguin git remote/hosting** — `origin` =
  `github.com/JamesonRGrieve/penguin-panel` (push target); `upstream` =
  `pelican-dev/panel` for clean rebases.
- **PDM (Proxmox Datacenter Manager)** — documented target, **parked**; v1 is
  PVE-only via `bpg/proxmox`.
- **User-visible rebrand** — deferred until after the Wings Phase 1 technical
  proof.
- **Phase 1 spike Proxmox target** — parked pending an operator-named node.
- **Pre-commit gates** — not yet wired.
