<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        // It's safer to drop foreign keys before any renames.
        // We will drop them by column name, which is more reliable than guessing the constraint name.
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                // To make this re-runnable, we must check if the column exists before dropping its FK
                if (Schema::hasColumn('users', 'id_level')) {
                    $table->dropForeign(['id_level']);
                }
                if (Schema::hasColumn('users', 'id_kategori_usaha')) {
                    $table->dropForeign(['id_kategori_usaha']);
                }
            });
        }
        if (Schema::hasTable('tbl_product')) {
            Schema::table('tbl_product', function (Blueprint $table) {
                if (Schema::hasColumn('tbl_product', 'id_user')) {
                    $table->dropForeign(['id_user']);
                }
                if (Schema::hasColumn('tbl_product', 'id_kategori_usaha')) {
                    $table->dropForeign(['id_kategori_usaha']);
                }
            });
        }
        if (Schema::hasTable('tbl_olshop_link')) {
            Schema::table('tbl_olshop_link', function (Blueprint $table) {
                if (Schema::hasColumn('tbl_olshop_link', 'id_produk')) {
                    $table->dropForeign(['id_produk']);
                }
            });
        }
        if (Schema::hasTable('katalogs')) {
            Schema::table('katalogs', function (Blueprint $table) {
                if (Schema::hasColumn('katalogs', 'sub_sektor_id')) {
                    $table->dropForeign(['sub_sektor_id']);
                }
            });
        }
        if (Schema::hasTable('tbl_user_temp')) {
            Schema::table('tbl_user_temp', function (Blueprint $table) {
                if (Schema::hasColumn('tbl_user_temp', 'id_level')) {
                    $table->dropForeign(['id_level']);
                }
                if (Schema::hasColumn('tbl_user_temp', 'id_kategori_usaha')) {
                    $table->dropForeign(['id_kategori_usaha']);
                }
            });
        }

        // Now, disable constraints as an extra safety measure and proceed.
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('tbl_artikel');

        if (Schema::hasTable('tbl_level') && !Schema::hasTable('levels')) {
            Schema::rename('tbl_level', 'levels');
        }
        if (Schema::hasTable('tbl_kategori_usaha') && !Schema::hasTable('business_categories')) {
            Schema::rename('tbl_kategori_usaha', 'business_categories');
        }
        if (Schema::hasTable('tbl_user_temp') && !Schema::hasTable('temporary_users')) {
            Schema::rename('tbl_user_temp', 'temporary_users');
        }
        if (Schema::hasTable('tbl_product') && !Schema::hasTable('products')) {
            Schema::rename('tbl_product', 'products');
        }
        if (Schema::hasTable('tbl_olshop_link') && !Schema::hasTable('online_store_links')) {
            Schema::rename('tbl_olshop_link', 'online_store_links');
        }
        if (Schema::hasTable('sub_sektors') && !Schema::hasTable('sub_sectors')) {
            Schema::rename('sub_sektors', 'sub_sectors');
        }
        if (Schema::hasTable('katalogs') && !Schema::hasTable('catalogs')) {
            Schema::rename('katalogs', 'catalogs');
        }

        if (Schema::hasTable('levels')) {
            Schema::table('levels', function (Blueprint $table) {
                if (Schema::hasColumn('levels', 'id_level')) {
                     // Change id to bigIncrements to match Prisma schema (UnsignedBigInt)
                    $table->unsignedBigInteger('id')->first()->change();
                    $table->dropColumn('id_level');
                } else if (!Schema::hasColumn('levels', 'id')) {
                    $table->bigIncrements('id')->first();
                } else {
                    $table->unsignedBigInteger('id')->change();
                }

                if (Schema::hasColumn('levels', 'level')) $table->renameColumn('level', 'name');
                if (!Schema::hasColumn('levels', 'created_at')) $table->timestamps(0);
            });
        }

        if (Schema::hasTable('business_categories')) {
            Schema::table('business_categories', function (Blueprint $table) {
                if (Schema::hasColumn('business_categories', 'id_kategori_usaha')) $table->renameColumn('id_kategori_usaha', 'id');
                if (Schema::hasColumn('business_categories', 'nama_kategori')) $table->renameColumn('nama_kategori', 'name');
            });
        }

        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                if (Schema::hasColumn('users', 'jk')) $table->renameColumn('jk', 'gender');
                if (Schema::hasColumn('users', 'nohp')) $table->renameColumn('nohp', 'phone_number');
                if (Schema::hasColumn('users', 'nama_usaha')) $table->renameColumn('nama_usaha', 'business_name');
                if (Schema::hasColumn('users', 'status_usaha')) $table->renameColumn('status_usaha', 'business_status');

                $table->dropColumn(array_filter(['id_level', 'id_kategori_usaha'], function($col) use ($table) {
                    return Schema::hasColumn($table->getTable(), $col);
                }));
            });
            Schema::table('users', function (Blueprint $table) {
                if (!Schema::hasColumn('users', 'level_id')) {
                    $table->unsignedBigInteger('level_id')->after('business_status');
                }
                if (!Schema::hasColumn('users', 'business_category_id')) {
                    $table->unsignedInteger('business_category_id')->nullable()->after('level_id');
                }
            });
        }

        if (Schema::hasTable('temporary_users')) {
            Schema::table('temporary_users', function (Blueprint $table) {
                if (Schema::hasColumn('temporary_users', 'nama_user')) $table->renameColumn('nama_user', 'name');
                if (Schema::hasColumn('temporary_users', 'jk')) $table->renameColumn('jk', 'gender');
                if (Schema::hasColumn('temporary_users', 'nohp')) $table->renameColumn('nohp', 'phone_number');
                if (Schema::hasColumn('temporary_users', 'nama_usaha')) $table->renameColumn('nama_usaha', 'business_name');
                if (Schema::hasColumn('temporary_users', 'status_usaha')) $table->renameColumn('status_usaha', 'business_status');

                $table->dropColumn(array_filter(['id_level', 'id_kategori_usaha'], function($col) use ($table) {
                    return Schema::hasColumn($table->getTable(), $col);
                }));
            });
            Schema::table('temporary_users', function (Blueprint $table) {
                if (!Schema::hasColumn('temporary_users', 'level_id')) {
                    $table->unsignedBigInteger('level_id')->after('business_status');
                }
                if (!Schema::hasColumn('temporary_users', 'business_category_id')) {
                    $table->unsignedInteger('business_category_id')->nullable()->after('level_id');
                }
            });
        }

        if (Schema::hasTable('products')) {
            Schema::table('products', function (Blueprint $table) {
                if (Schema::hasColumn('products', 'id_produk')) $table->renameColumn('id_produk', 'id');
                if (Schema::hasColumn('products', 'nama_pelaku')) $table->renameColumn('nama_pelaku', 'owner_name');
                if (Schema::hasColumn('products', 'nama_produk')) $table->renameColumn('nama_produk', 'name');
                if (Schema::hasColumn('products', 'deskripsi')) $table->renameColumn('deskripsi', 'description');
                if (Schema::hasColumn('products', 'harga')) $table->renameColumn('harga', 'price');
                if (Schema::hasColumn('products', 'stok')) $table->renameColumn('stok', 'stock');
                if (Schema::hasColumn('products', 'gambar')) $table->renameColumn('gambar', 'image');
                if (Schema::hasColumn('products', 'nohp')) $table->renameColumn('nohp', 'phone_number');
                if (Schema::hasColumn('products', 'tgl_upload')) $table->renameColumn('tgl_upload', 'uploaded_at');
                if (Schema::hasColumn('products', 'status_produk')) $table->renameColumn('status_produk', 'status');

                $table->dropColumn(array_filter(['id_user', 'id_kategori_usaha'], function($col) use ($table) {
                    return Schema::hasColumn($table->getTable(), $col);
                }));
            });
            Schema::table('products', function (Blueprint $table) {
                if (!Schema::hasColumn('products', 'user_id')) {
                    $table->unsignedBigInteger('user_id')->nullable()->after('uploaded_at');
                }
            });
        }

        if (Schema::hasTable('online_store_links')) {
            Schema::table('online_store_links', function (Blueprint $table) {
                if (Schema::hasColumn('online_store_links', 'id_link')) $table->renameColumn('id_link', 'id');
                if (Schema::hasColumn('online_store_links', 'nama_platform')) $table->renameColumn('nama_platform', 'platform_name');

                if (Schema::hasColumn('online_store_links', 'id_produk')) {
                    $table->dropColumn('id_produk');
                }
            });
            Schema::table('online_store_links', function (Blueprint $table) {
                if (!Schema::hasColumn('online_store_links', 'product_id')) {
                    $table->unsignedInteger('product_id')->after('id');
                }
            });
        }

        if (Schema::hasTable('catalogs')) {
            Schema::table('catalogs', function (Blueprint $table) {
                if (Schema::hasColumn('catalogs', 'produk')) $table->renameColumn('produk', 'product_name');
                if (Schema::hasColumn('catalogs', 'harga')) $table->renameColumn('harga', 'price');
                if (Schema::hasColumn('catalogs', 'no_hp')) $table->renameColumn('no_hp', 'phone_number');

                if (Schema::hasColumn('catalogs', 'sub_sektor_id')) {
                    $table->dropColumn('sub_sektor_id');
                }
            });
            Schema::table('catalogs', function (Blueprint $table) {
                if (!Schema::hasColumn('catalogs', 'sub_sector_id')) {
                    $table->unsignedBigInteger('sub_sector_id')->after('id');
                }
            });
        }

        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                $table->foreign('level_id')->references('id')->on('levels')->onUpdate('restrict');
                $table->foreign('business_category_id')->references('id')->on('business_categories')->onUpdate('restrict')->onDelete('restrict');
            });
        }

        if (Schema::hasTable('temporary_users')) {
            Schema::table('temporary_users', function (Blueprint $table) {
                $table->foreign('level_id')->references('id')->on('levels')->onUpdate('restrict');
                $table->foreign('business_category_id')->references('id')->on('business_categories')->onUpdate('restrict')->onDelete('restrict');
            });
        }

        if (Schema::hasTable('products')) {
            Schema::table('products', function (Blueprint $table) {
                $table->foreign('user_id')->references('id')->on('users')->onUpdate('restrict');
            });
        }

        if (Schema::hasTable('online_store_links')) {
            Schema::table('online_store_links', function (Blueprint $table) {
                $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            });
        }

        if (Schema::hasTable('catalogs')) {
            Schema::table('catalogs', function (Blueprint $table) {
                $table->foreign('sub_sector_id')->references('id')->on('sub_sectors')->onDelete('cascade');
            });
        }

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();

        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropForeign(['level_id']);
                $table->dropForeign(['business_category_id']);
            });
        }
        if (Schema::hasTable('temporary_users')) {
            Schema::table('temporary_users', function (Blueprint $table) {
                $table->dropForeign(['level_id']);
                $table->dropForeign(['business_category_id']);
            });
        }
        if (Schema::hasTable('products')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
            });
        }
        if (Schema::hasTable('online_store_links')) {
            Schema::table('online_store_links', function (Blueprint $table) {
                $table->dropForeign(['product_id']);
            });
        }
        if (Schema::hasTable('catalogs')) {
            Schema::table('catalogs', function (Blueprint $table) {
                $table->dropForeign(['sub_sector_id']);
            });
        }

        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn(['level_id', 'business_category_id']);
            });
            Schema::table('users', function (Blueprint $table) {
                $table->integer('id_level');
                $table->integer('id_kategori_usaha')->nullable();
                if (Schema::hasColumn('users', 'gender')) $table->renameColumn('gender', 'jk');
                if (Schema::hasColumn('users', 'phone_number')) $table->renameColumn('phone_number', 'nohp');
                if (Schema::hasColumn('users', 'business_name')) $table->renameColumn('business_name', 'nama_usaha');
                if (Schema::hasColumn('users', 'business_status')) $table->renameColumn('business_status', 'status_usaha');
            });
        }
        if (Schema::hasTable('temporary_users')) {
            Schema::table('temporary_users', function (Blueprint $table) {
                $table->dropColumn(['level_id', 'business_category_id']);
            });
            Schema::table('temporary_users', function (Blueprint $table) {
                $table->integer('id_level');
                $table->integer('id_kategori_usaha')->nullable();
                if (Schema::hasColumn('temporary_users', 'name')) $table->renameColumn('name', 'nama_user');
                if (Schema::hasColumn('temporary_users', 'gender')) $table->renameColumn('gender', 'jk');
                if (Schema::hasColumn('temporary_users', 'phone_number')) $table->renameColumn('phone_number', 'nohp');
                if (Schema::hasColumn('temporary_users', 'business_name')) $table->renameColumn('business_name', 'nama_usaha');
                if (Schema::hasColumn('temporary_users', 'business_status')) $table->renameColumn('business_status', 'status_usaha');
            });
        }
        if (Schema::hasTable('products')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn(['user_id']);
            });
            Schema::table('products', function (Blueprint $table) {
                $table->unsignedBigInteger('id_user')->nullable();
                $table->integer('id_kategori_usaha')->nullable();
                if (Schema::hasColumn('products', 'id')) $table->renameColumn('id', 'id_produk');
                if (Schema::hasColumn('products', 'owner_name')) $table->renameColumn('owner_name', 'nama_pelaku');
                if (Schema::hasColumn('products', 'name')) $table->renameColumn('name', 'nama_produk');
                if (Schema::hasColumn('products', 'description')) $table->renameColumn('description', 'deskripsi');
                if (Schema::hasColumn('products', 'price')) $table->renameColumn('price', 'harga');
                if (Schema::hasColumn('products', 'stock')) $table->renameColumn('stock', 'stok');
                if (Schema::hasColumn('products', 'image')) $table->renameColumn('image', 'gambar');
                if (Schema::hasColumn('products', 'phone_number')) $table->renameColumn('phone_number', 'nohp');
                if (Schema::hasColumn('products', 'uploaded_at')) $table->renameColumn('uploaded_at', 'tgl_upload');
                if (Schema::hasColumn('products', 'status')) $table->renameColumn('status', 'status_produk');
            });
        }
        if (Schema::hasTable('online_store_links')) {
            Schema::table('online_store_links', function (Blueprint $table) {
                $table->dropColumn(['product_id']);
            });
            Schema::table('online_store_links', function (Blueprint $table) {
                $table->integer('id_produk');
                if (Schema::hasColumn('online_store_links', 'id')) $table->renameColumn('id', 'id_link');
                if (Schema::hasColumn('online_store_links', 'platform_name')) $table->renameColumn('platform_name', 'nama_platform');
            });
        }
        if (Schema::hasTable('catalogs')) {
            Schema::table('catalogs', function (Blueprint $table) {
                $table->dropColumn(['sub_sector_id']);
            });
            Schema::table('catalogs', function (Blueprint $table) {
                $table->unsignedBigInteger('sub_sektor_id');
                if (Schema::hasColumn('catalogs', 'product_name')) $table->renameColumn('product_name', 'produk');
                if (Schema::hasColumn('catalogs', 'price')) $table->renameColumn('price', 'harga');
                if (Schema::hasColumn('catalogs', 'phone_number')) $table->renameColumn('phone_number', 'no_hp');
            });
        }

        if (Schema::hasTable('levels') && !Schema::hasTable('tbl_level')) {
            Schema::rename('levels', 'tbl_level');
        }
        if (Schema::hasTable('business_categories') && !Schema::hasTable('tbl_kategori_usaha')) {
            Schema::rename('business_categories', 'tbl_kategori_usaha');
        }
        if (Schema::hasTable('temporary_users') && !Schema::hasTable('tbl_user_temp')) {
            Schema::rename('temporary_users', 'tbl_user_temp');
        }
        if (Schema::hasTable('products') && !Schema::hasTable('tbl_product')) {
            Schema::rename('products', 'tbl_product');
        }
        if (Schema::hasTable('online_store_links') && !Schema::hasTable('tbl_olshop_link')) {
            Schema::rename('online_store_links', 'tbl_olshop_link');
        }
        if (Schema::hasTable('catalogs') && !Schema::hasTable('katalogs')) {
            Schema::rename('catalogs', 'katalogs');
        }
        if (Schema::hasTable('sub_sectors') && !Schema::hasTable('sub_sektors')) {
            Schema::rename('sub_sectors', 'sub_sektors');
        }

        if (!Schema::hasTable('tbl_artikel')) {
            Schema::create('tbl_artikel', function (Blueprint $table) {
                $table->increments('id_artikel');
                $table->string('judul', 150);
                $table->string('gambar', 100)->nullable();
                $table->text('deskripsi_singkat')->nullable();
                $table->longText('isi_lengkap')->nullable();
                $table->date('tanggal_upload');
                $table->unsignedBigInteger('id_user')->nullable();
                $table->foreign('id_user')->references('id')->on('users')->onUpdate('restrict')->onDelete('restrict');
                $table->index('id_user');
            });
        }

        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                $table->foreign('id_level')->references('id_level')->on('tbl_level')->onUpdate('restrict');
                $table->foreign('id_kategori_usaha')->references('id_kategori_usaha')->on('tbl_kategori_usaha')->onUpdate('restrict')->onDelete('restrict');
            });
        }
        if (Schema::hasTable('tbl_user_temp')) {
            Schema::table('tbl_user_temp', function (Blueprint $table) {
                $table->foreign('id_kategori_usaha')->references('id_kategori_usaha')->on('tbl_kategori_usaha')->onUpdate('restrict')->onDelete('restrict');
                $table->foreign('id_level')->references('id_level')->on('tbl_level')->onUpdate('restrict');
            });
        }
        if (Schema::hasTable('tbl_product')) {
            Schema::table('tbl_product', function (Blueprint $table) {
                $table->foreign('id_user')->references('id')->on('users')->onUpdate('restrict');
                $table->foreign('id_kategori_usaha')->references('id_kategori_usaha')->on('tbl_kategori_usaha')->onUpdate('restrict')->onDelete('restrict');
            });
        }
        if (Schema::hasTable('tbl_olshop_link')) {
            Schema::table('tbl_olshop_link', function (Blueprint $table) {
                $table->foreign('id_produk')->references('id_produk')->on('tbl_product')->onDelete('cascade');
            });
        }
        if (Schema::hasTable('katalogs')) {
            Schema::table('katalogs', function (Blueprint $table) {
                $table->foreign('sub_sektor_id')->references('id')->on('sub_sektors')->onDelete('cascade');
            });
        }

        Schema::enableForeignKeyConstraints();
    }
};
