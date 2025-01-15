#!/bin/bash

# Pastikan model name diberikan sebagai argumen
if [ -z "$1" ]; then
    echo "Usage: ./make_model.sh ModelName"
    exit 1
fi

MODEL_NAME=$1
TABLE_NAME="${MODEL_NAME,,}s"

# Buat migrasi
php artisan make:migration create_${TABLE_NAME}_table

# Buat model di folder Models
MODEL_PATH="app/Models/$MODEL_NAME.php"

cat <<EOL > $MODEL_PATH
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class $MODEL_NAME extends Model
{
     protected \$guarded = ['id'];
}
EOL

echo "Model created at $MODEL_PATH and migration created for $MODEL_NAME."

