## Installation and Configuration

### 1. Clone the repository

```bash
git clone <repository-url>
cd payment_processor
```

### 2. Configure the environment

```bash
# Copy the environment file
cp .env.example .env

# Configure the Asaas variables in .env
ASAAS_API_KEY=your_sandbox_api_key
ASAAS_BASE_URL=https://sandbox.asaas.com/api/v3/
```

### 3. Start the environment with Docker

```bash
# Install the dependencies
./vendor/bin/sail composer install

# Start the containers
./vendor/bin/sail up -d

# Generate the application key
./vendor/bin/sail artisan key:generate

# Run the migrations
./vendor/bin/sail artisan migrate
```
