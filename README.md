# 📬 Mail Telegram Forwarder

![PHP Version](https://img.shields.io/badge/PHP-8.2-brightgreen.svg)
![Symfony](https://img.shields.io/badge/Symfony-7.3-black.svg?logo=symfony)
![Composer](https://img.shields.io/badge/Composer-Compatible-orange.svg)
![Docker](https://img.shields.io/badge/Docker-✓-blue?logo=docker&logoColor=white&style=flat)
![Docker Compose](https://img.shields.io/badge/Docker_Compose-✓-blue?logo=docker&logoColor=white&style=flat)
![PostgreSQL](https://img.shields.io/badge/PostgreSQL-17-blue.svg?logo=postgresql)
![License](https://img.shields.io/badge/License-MIT-blue.svg)

![Logo](public/logo.png)

This is a Telegram bot that automatically forwards incoming emails to a specified Telegram chat using the Telegram Bot API.

---

## 🚀 Installation

Follow the steps below to install and run the bot locally or on a server:
### 1. Clone the repository
```bash
git clone git@github.com:forest-chan/mail-telegram-forwarder.git
```
### 2. Move into the project directory
```bash
cd mail-telegram-forwarder
```
### 3. Copy the example environment configuration
```bash
cp .env.example .env
```
### 4. Edit environment configuration
```bash
nano .env
```
### 5. Build via Docker Compose 
```bash
docker-compose build
```
### 6. Run with Docker compose
```bash
docker-compose -f docker-compose.yaml up -d
```
