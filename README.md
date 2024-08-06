# IntuitRisks

IntuitRisks is a Bachelor’s project developed in collaboration with IntuitSens, a company specializing in crisis management, based in Penthalaz (VD). This project was completed as part of the Bachelor’s studies at the School of Engineering and Management of Vaud (HEIG-VD).

## Context

In an increasingly uncertain economic environment marked by various risks (such as health crises, cyberattacks, natural disasters, etc.), businesses, especially small and medium-sized enterprises (SMEs), face significant challenges in safeguarding their operations. SMEs, often with limited resources, require risk management solutions that are simple, accessible, and effective to proactively prevent and manage crises.

## Objectives

-   Develop a functional prototype allowing users to register, configure their organization, and select relevant risks in less than 15 to 20 minutes.
-   Simplify and optimize the user interface to ensure quick adoption and high user satisfaction.
-   Lay the groundwork for future features, such as generating emergency plans and risk response strategies.

## Installation

To get started with the IntuitRisks project, follow these steps to set up the development environment and run the application locally:

### Prerequisites

1. **PHP**: Version 8.2 or higher
2. **Node.js**: Version 16 or higher
3. **Composer**: PHP package manager
4. **npm or yarn**: JavaScript package managers

### Setup

1. **Clone the repository**

    ```bash
    git clone https://github.com/pablo-crotti/intuit-risks.git
    cd intuitrisks
    ```

2. **Install backend dependencies**

    ```bash
    composer install
    ```

3. **Configure environment variables**

    ```bash
    cp .env.example .env
    ```

4. **Generate application key**

    ```bash
    php artisan key:generate

    ```

5. **Run migrations**

    ```bash
    php artisan migrate

    ```

6. **Install frontend dependencies**

    ```bash
    npm install

    ```

    or if using yarn:

    ```bash
    yarn install

    ```

7. **Run the development server**
   Start the backend development server :

    ```bash
    php artisan serve

    ```

    And for the frontend development server, in a new terminal window :

    ```bash
    npm run dev
    ```

    or if using yarn :

    ```bash
    yarn dev
    ```

8. **Build frontend assets**

    ```bash
    npm run dev
    /*OR*/
    yarn dev

    ```
