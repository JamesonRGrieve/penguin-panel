<img width="20%" src="public/pelican.svg" alt="logo">

# Penguin Panel

**Fly High, Game On: Penguin's pledge for unrivaled game servers.**

![Latest Release](https://img.shields.io/github/v/release/JamesonRGrieve/penguin-panel?style=flat&label=Latest%20Release&labelColor=rgba(0%2C%2070%2C%20114%2C%201)&color=rgba(255%2C%20255%2C%20255%2C%201))

Penguin Panel is a free, open-source game server control panel built for communities, hosts, and self-hosters.
It gives users a modern web UI for creating and managing game servers while running each server as an isolated
**Proxmox LXC** container through Penguin Wings.

Penguin is a soft fork of [Pelican Panel](https://github.com/pelican-dev/panel) that targets **direct Proxmox LXC**
instead of Docker, driven by embedded OpenTofu and the `bpg/proxmox` provider. It keeps compatibility with the
Pelican/Pterodactyl egg ecosystem.

## Why Penguin?

Use Penguin if you want:
- A Proxmox LXC-native alternative in the Pelican/Pterodactyl ecosystem
- LXC-isolated game servers, realized declaratively (OpenTofu + `bpg/proxmox`)
- Support for Minecraft, SteamCMD games, databases, bots, voice servers, and more
- A free, open-source panel suitable for personal servers, communities, and hosting providers

## Support

* [Read the documentation](https://pengwings.dev/docs)
* [Penguin Wings](https://github.com/JamesonRGrieve/penguin-wings)
* [Open a GitHub Discussion for general project questions](https://github.com/JamesonRGrieve/penguin-panel/discussions)
* [Open an Issue for confirmed bugs](https://github.com/JamesonRGrieve/penguin-panel/issues)

## Supported Games and Servers

Penguin supports a wide variety of games by utilizing Proxmox LXC containers to isolate each instance.
This gives you the power to run game servers without bloating machines with a host of additional dependencies.

Penguin imports the existing Pelican/Pterodactyl eggs. Some popular eggs include:

| Category                                                             | Eggs            |               |                    |                |
|----------------------------------------------------------------------|-----------------|---------------|--------------------|----------------|
| [Minecraft](https://github.com/pelican-eggs/minecraft)               | Paper           | Sponge        | Bungeecord         | Waterfall      |
| [SteamCMD](https://github.com/pelican-eggs/steamcmd)                 | 7 Days to Die   | ARK: Survival | Arma 3             | Counter Strike |
|                                                                      | DayZ            | Enshrouded    | Left 4 Dead        | Palworld       |
|                                                                      | Project Zomboid | Satisfactory  | Sons of the Forest | Starbound      |
| [Standalone Games](https://github.com/pelican-eggs/games-standalone) | Among Us        | Factorio      | FTL                | GTA            |
|                                                                      | Kerbal Space    | Mindustry     | Rimworld           | Terraria       |
| [Discord Bots](https://github.com/pelican-eggs/chatbots)             | Redbot          | JMusicBot     | Dynamica           |                |
| [Voice Servers](https://github.com/pelican-eggs/voice)               | Mumble          | Teamspeak     | Lavalink           |                |
| [Software](https://github.com/pelican-eggs/software)                 | Elasticsearch   | Gitea         | Grafana            | RabbitMQ       |
| [Programming](https://github.com/pelican-eggs/generic)               | Node.js         | Python        | Java               | C#             |
| [Databases](https://github.com/pelican-eggs/database)                | Redis           | MariaDB       | PostgreSQL         | MongoDB        |
| [Storage](https://github.com/pelican-eggs/storage)                   | S3              | SFTP Share    |                    |                |
| [Monitoring](https://github.com/pelican-eggs/monitoring)             | Prometheus      | Loki          |                    |                |

## Contributing

We welcome contributions from developers, designers, translators, testers, documentation writers, and egg maintainers.

Good places to start:

- Read `contributing.md`
- Browse open issues
- Improve docs or submit egg updates

## Supporting the Project

Penguin is built and maintained by volunteers. If Penguin helps you or your community, consider supporting ongoing development:

- [Contribute code or documentation](https://github.com/JamesonRGrieve/penguin-panel)
- Share Penguin with other server owners

## Credits

Penguin Panel is a soft fork of [Pelican Panel](https://github.com/pelican-dev/panel) (AGPL-3.0), which itself
builds on the Pterodactyl ecosystem. Thank you to those projects and their contributors.

*Penguin — AGPL-3.0-or-later.*
