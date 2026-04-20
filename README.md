<!-- ⚠️ This README has been generated from the file(s) "blueprint.md" ⚠️-->
[![-----------------------------------------------------](https://raw.githubusercontent.com/andreasbm/readme/master/assets/lines/colored.png)](#-pkgname-)

# ➤ pkg.name

{{ template:badges }}

pkg.description

---


[![-----------------------------------------------------](https://raw.githubusercontent.com/andreasbm/readme/master/assets/lines/colored.png)](#-table-of-contents)

## ➤ 📋 Table of Contents


[![-----------------------------------------------------](https://raw.githubusercontent.com/andreasbm/readme/master/assets/lines/colored.png)](#table-of-contents)

## ➤ Table of Contents

* [➤ pkg.name](#-pkgname)
	* [➤ 📋 Table of Contents](#--table-of-contents)
	* [➤ 🚀 Overview](#--overview)
		* [What This Project Does](#what-this-project-does)
		* [Target Audience](#target-audience)
		* [Key Differentiators](#key-differentiators)
	* [➤ ✨ Features](#--features)
		* [Core Features](#core-features)
		* [Technical Highlights](#technical-highlights)
		* [Future Roadmap](#future-roadmap)
	* [➤ 📦 Tech Stack](#--tech-stack)
	* [➤ 🚀 Quick Start](#--quick-start)
		* [Prerequisites](#prerequisites)
		* [Installation (30 seconds)](#installation-30-seconds)
* [➤ Clone the repository](#-clone-the-repository)
* [➤ No dependencies to install – PHP runs everything](#-no-dependencies-to-install--php-runs-everything)
* [➤ Start the portable server](#-start-the-portable-server)

---


[![-----------------------------------------------------](https://raw.githubusercontent.com/andreasbm/readme/master/assets/lines/colored.png)](#-overview)

## ➤ 🚀 Overview

### What This Project Does
This project solves the problem of outdated and inaccessible pricing information in a medical center. Patients and staff currently rely on paper lists, verbal inquiries, or outdated displays to know the cost of services, medicines, and supplies. This system provides a self-service digital kiosk where anyone can quickly search, filter, and view current prices. It also gives administrators a simple way to update all pricing by uploading an Excel file – no technical skills required.

### Target Audience
- **Primary:** Patients and visitors at GoodSam Medical Center who need to check prices
- **Secondary:** Hospital administrators and billing staff who need to update pricing
- **Tertiary:** Developers who want to set up similar kiosks for other clinics or businesses

### Key Differentiators
- **Truly portable** – Runs with `php -S` – no Apache, no XAMPP, no installation
- **No database setup** – SQLite works out of the box; MySQL optional for scaling
- **Excel-based updates** – Staff already know Excel; no training needed
- **Single command to start** – Open terminal, type one line, it's running

---


[![-----------------------------------------------------](https://raw.githubusercontent.com/andreasbm/readme/master/assets/lines/colored.png)](#-features)

## ➤ ✨ Features

### Core Features
- [x] **Public pricing display** – Browse all services, supplies, and medicines
- [x] **Live search** – Type to filter results instantly, no page reload
- [x] **Category filtering** – Toggle between Services, Supplies, and Medicines
- [x] **Admin panel** – Password-protected area for data management
- [x] **Excel file upload** – Bulk update prices using `.xlsx` files
- [x] **Portable server** – Works with PHP's built-in web server

### Technical Highlights
- [x] **Zero configuration** – SQLite means no database setup
- [x] **Mobile responsive** – Tailwind CSS ensures it works on tablets and phones
- [x] **Fast search** – Client-side JavaScript filtering; no database round-trips
- [x] **Secure by design** – Admin routes check authentication before serving
- [x] **Excel parsing** – Uses PhpSpreadsheet to read `.xlsx` files

### Future Roadmap
- [ ] Print price lists from the kiosk
- [ ] QR code on each item for easy sharing
- [ ] Dark mode toggle
- [ ] Export current pricing to PDF
- [ ] Multiple language support (Filipino/English)
- [ ] Audit log of who updated what and when
- [ ] Automatic backup before Excel uploads

---


[![-----------------------------------------------------](https://raw.githubusercontent.com/andreasbm/readme/master/assets/lines/colored.png)](#-tech-stack)

## ➤ 📦 Tech Stack

| Category | Technology | Version | Purpose |
|----------|------------|---------|---------|
| **Frontend** | | | |
| Framework | Vanilla JavaScript | ES2020 | No framework overhead, pure DOM manipulation |
| Styling | Tailwind CSS | 3.x | Utility-first CSS for rapid UI development |
| Icons | Font Awesome | 6.x | Clean icons for search and categories |
| **Backend** | | | |
| Runtime/Server | PHP | 7.4+ | Built-in server for portability |
| Excel Parsing | PhpSpreadsheet | 1.x | Read uploaded Excel files |
| Authentication | PHP Sessions | Built-in | Simple admin session management |
| **Database** | | | |
| Primary DB | SQLite | 3.x | Zero-config, file-based database |
| Optional DB | MySQL | 5.7+ | For larger deployments |
| **Tooling** | | | |
| Package Manager | npm (for Tailwind only) | - | Build Tailwind CSS |
| Build Tool | PostCSS | - | Process Tailwind |
| Local Server | PHP CLI | 7.4+ | `php -S localhost:8000` |

---


[![-----------------------------------------------------](https://raw.githubusercontent.com/andreasbm/readme/master/assets/lines/colored.png)](#-quick-start)

## ➤ 🚀 Quick Start

### Prerequisites

| Requirement | Version | Installation Link |
|-------------|---------|-------------------|
| PHP | 7.4 or higher | https://windows.php.net/download/ or `brew install php` |
| Git | Latest | https://git-scm.com/ |
| Web Browser | Any modern | Chrome, Firefox, Edge, Safari |

**Note:** No database installation is required. SQLite is built into PHP.

### Installation (30 seconds)

```bash

[![-----------------------------------------------------](https://raw.githubusercontent.com/andreasbm/readme/master/assets/lines/colored.png)](#clone-the-repository)

# ➤ Clone the repository
git clone pkg.repository.url
cd pkg.name


[![-----------------------------------------------------](https://raw.githubusercontent.com/andreasbm/readme/master/assets/lines/colored.png)](#no-dependencies-to-install--php-runs-everything)

# ➤ No dependencies to install – PHP runs everything


[![-----------------------------------------------------](https://raw.githubusercontent.com/andreasbm/readme/master/assets/lines/colored.png)](#start-the-portable-server)

# ➤ Start the portable server
php -S localhost:8000 -t www
