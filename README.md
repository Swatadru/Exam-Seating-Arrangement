# 🎓 Exam Hall Management & Seating Arrangement (Modern Edition)

A premium, cloud-ready PHP application designed to automate examination hall allotments and seating arrangements with a high-fidelity, mobile-responsive user experience.

![Premium UI Splash](https://github.com/Swatadru/Exam-Seating-Arrangement/raw/main/assets/images/preview.png) *(Update this link once image is pushed)*

## 🌟 Modern Enhancements

- **✨ Premium Glassmorphism UI**: A stunning, modern design with smooth animations and deep-space aesthetics.
- **📱 Fully Mobile Responsive**: Re-engineered sidebar, navigation, and seating maps to work perfectly on any screen size.
- **🔒 Security Hardened**: Transitioned core modules to **Prepared Statements** to eliminate SQL Injection risks.
- **🚀 Portable Architecture**: Migrated to a **Portable SQLite** database backend—no more complex MySQL setup required.
- **☁️ Cloud Ready**: Native support for **Render**, **Docker**, and **Docker Compose** for instant deployment.

---

## 🛠️ Tech Stack

- **Backend**: PHP 7.4+ (SQLite / MySQL Compatible via abstraction)
- **Frontend**: HTML5, Vanilla CSS3, Javascript (ES6), jQuery
- **Containers**: Docker, Docker Compose
- **Compatibility**: SQLite3 (Local/Portable), MySQL (Legacy Support)

---

## 🚀 Quick Start / Deployment

### Option 1: Instant Local Run (Recommended)
This method requires no installation of XAMPP or MySQL.
1. Clone the repository.
2. Open the folder in any PHP-capable environment or use the included `.portable_stack` (if available).
3. The system will automatically initialize the `database.sqlite` file on first run.
4. **Access**: `http://localhost/index.php`

### Option 2: Docker (Production Grade)
```bash
docker-compose up -d
```
Access at `http://localhost:8000`.

### Option 3: Cloud Deployment (Render)
1. Connect your GitHub fork to **Render**.
2. Create a new **Web Service**.
3. Use the integrated `render.yaml` for automatic provisioning.

---

## 🏗️ Modules & Features

- **Dashboard**: High-level stats on students, teachers, and rooms.
- **Teacher/Student Management**: Modern CRUD interfaces for managing academic staff and pupils.
- **Exam Allotment**: Conflict-free seating generation logic.
- **Seating Map**: Fully responsive room layout visualization with horizontal scroll support.
- **Appearance Management**: Customize logos and portal backgrounds.

---

## 🔐 Credentials (Default)

| Role | Email | Password |
| :--- | :--- | :--- |
| **Admin** | `admin@gmail.com` | `admin` |
| **Student** | `student@gmail.com` | `123` |
| **Teacher** | `teacher@gmail.com` | `123` |

---

## 📄 License
This project is licensed under the [LICENSE](LICENSE) file.

## 🤝 Developed by
**Swatadru Paul** - [GitHub Profile](https://github.com/Swatadru)
