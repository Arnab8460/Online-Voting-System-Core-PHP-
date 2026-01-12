## 🗳️ Online Voting System (PHP & MySQL)

This project is a role-based online voting system developed using **Core PHP**, **MySQL**, **HTML**, **Tailwind CSS**, and **Sessions**.

### 🔑 User Roles

* **Voter (Role = 1)**

  * Can log in and view all registered groups/candidates
  * Can vote **only once**
  * Vote is securely stored in a separate `votes` table

* **Group / Candidate (Role = 2)**

  * Can log in to view their profile
  * Can see **total votes received**
  * Cannot cast votes

### ⚙️ Core Features

* Secure login system with **hashed passwords**
* Role-based dashboard redirection
* One-user-one-vote logic
* Separate votes table for clean database design
* Profile image upload with fallback avatar
* Session-based authentication
* Clean and responsive UI using Tailwind CSS

### 🧠 System Flow

1. Users register as **Voter** or **Group**
2. Voters log in → view candidates → cast a vote
3. Vote data is stored in the `votes` table
4. Groups log in → view total votes received
5. System prevents duplicate voting

### 🛠️ Tech Stack

* PHP (Core PHP)
* MySQL
* HTML5
* Tailwind CSS
* JavaScript
* Session Authentication

This project demonstrates **authentication, authorization, database normalization, and real-world voting logic**, making it suitable for academic and portfolio purposes.
