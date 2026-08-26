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
- **Egg / image semantics.** An egg's Docker image reference becomes a **base LXC
  template + install steps** (run by Wings as atomic Ansible). The egg install
  contract is *adapted*, not the egg ecosystem discarded.
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

## Quality gates (workspace §8)

Pint (format check), PHPStan (static analysis), PHPUnit (full suite) all green via
the pre-commit hook wired at bootstrap; coverage/typing ratchets never regress.
`--no-verify` forbidden without explicit authorization.

## Where Penguin work sits

~90% of the Docker→LXC work is in **Penguin Wings** (the container-runtime
rearchitecture: embedded Tofu, `bpg/proxmox`, persistent-LXC lifecycle, the
in-container `penguin-agent` for console/SFTP/stats/backups). Panel's slice is the
four bullets above. The companion `penguin-wings` repo's `CLAUDE.md` holds the
full daemon architecture and the phase plan.

## Open / parked decisions (shared)

- **Penguin git remote/hosting** — undecided; only `upstream` is wired.
- **PDM (Proxmox Datacenter Manager)** — documented target, **parked**; v1 is
  PVE-only via `bpg/proxmox`.
- **User-visible rebrand** — deferred until after the Wings Phase 1 technical
  proof.
- **Phase 1 spike Proxmox target** — parked pending an operator-named node.
- **Pre-commit gates** — not yet wired.
