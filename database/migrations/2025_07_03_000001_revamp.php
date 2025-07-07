<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('tbl_level')) {
            Schema::create('tbl_level', function (Blueprint $table) {
                $table->increments('id_level');
                $table->string('level', 25)->nullable();
            });
        } else {
            Schema::table('tbl_level', function (Blueprint $table) {
                if (!Schema::hasColumn('tbl_level', 'level')) {
                    $table->string('level', 25)->nullable();
                }
            });
        }

        if (!Schema::hasTable('tbl_kategori_usaha')) {
            Schema::create('tbl_kategori_usaha', function (Blueprint $table) {
                $table->increments('id_kategori_usaha');
                $table->string('nama_kategori', 50)->unique();
                $table->string('image', 255)->nullable();
            });
        } else {
            Schema::table('tbl_kategori_usaha', function (Blueprint $table) {
                if (!Schema::hasColumn('tbl_kategori_usaha', 'nama_kategori')) {
                    $table->string('nama_kategori', 50)->unique();
                }
                if (!Schema::hasColumn('tbl_kategori_usaha', 'image')) {
                    $table->string('image', 255)->nullable();
                }
            });
        }

        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->unsignedBigInteger('id', true);
                $table->string('name', 255);
                $table->string('email', 255)->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password', 255);
                $table->string('remember_token', 100)->nullable();
                $table->timestamps(0);
                $table->string('username', 45)->nullable()->unique();
                $table->enum('jk', ['Laki-laki', 'Perempuan'])->nullable();
                $table->string('nohp', 20)->nullable();
                $table->string('image', 255)->nullable();
                $table->string('nama_usaha', 100)->nullable();
                $table->enum('status_usaha', ['BARU', 'SUDAH_LAMA'])->nullable();
                $table->unsignedInteger('id_level');
                $table->unsignedInteger('id_kategori_usaha')->nullable();
                $table->string('resetPasswordToken', 255)->nullable()->unique();
                $table->dateTime('resetPasswordTokenExpiry', 0)->nullable();
                $table->timestamp('verifiedAt')->nullable();
                $table->foreign('id_level')->references('id_level')->on('tbl_level')->onUpdate('restrict');
                $table->foreign('id_kategori_usaha')->references('id_kategori_usaha')->on('tbl_kategori_usaha')->onUpdate('restrict')->onDelete('restrict');
                $table->index('id_level');
                $table->index('id_kategori_usaha');
            });
        } else {
            Schema::table('users', function (Blueprint $table) {
                if (!Schema::hasColumn('users', 'name')) { $table->string('name', 255); }
                if (!Schema::hasColumn('users', 'email')) { $table->string('email', 255)->unique(); }
                if (!Schema::hasColumn('users', 'email_verified_at')) { $table->timestamp('email_verified_at')->nullable(); }
                if (!Schema::hasColumn('users', 'password')) { $table->string('password', 255); }
                if (!Schema::hasColumn('users', 'remember_token')) { $table->string('remember_token', 100)->nullable(); }
                if (!Schema::hasColumn('users', 'created_at') && !Schema::hasColumn('users', 'updated_at')) { $table->timestamps(0); }
                if (!Schema::hasColumn('users', 'username')) { $table->string('username', 45)->nullable()->unique(); }
                if (!Schema::hasColumn('users', 'jk')) { $table->enum('jk', ['Laki-laki', 'Perempuan'])->nullable(); }
                if (!Schema::hasColumn('users', 'nohp')) { $table->string('nohp', 20)->nullable(); }
                if (!Schema::hasColumn('users', 'image')) { $table->string('image', 255)->nullable(); }
                if (!Schema::hasColumn('users', 'nama_usaha')) { $table->string('nama_usaha', 100)->nullable(); }
                if (!Schema::hasColumn('users', 'status_usaha')) { $table->enum('status_usaha', ['BARU', 'SUDAH_LAMA'])->nullable(); }
                if (!Schema::hasColumn('users', 'id_level')) { $table->unsignedInteger('id_level'); }
                if (!Schema::hasColumn('users', 'id_kategori_usaha')) { $table->unsignedInteger('id_kategori_usaha')->nullable(); }
                if (!Schema::hasColumn('users', 'resetPasswordToken')) { $table->string('resetPasswordToken', 255)->nullable()->unique(); }
                if (!Schema::hasColumn('users', 'resetPasswordTokenExpiry')) { $table->dateTime('resetPasswordTokenExpiry', 0)->nullable(); }
                if (!Schema::hasColumn('users', 'verifiedAt')) { $table->timestamp('verifiedAt')->nullable(); }
            });
        }

        if (!Schema::hasTable('tbl_user_temp')) {
            Schema::create('tbl_user_temp', function (Blueprint $table) {
                $table->increments('id');
                $table->string('nama_user', 35);
                $table->string('username', 45)->unique();
                $table->string('email', 100)->unique();
                $table->string('password', 255);
                $table->enum('jk', ['Laki-laki', 'Perempuan']);
                $table->string('nohp', 20)->nullable();
                $table->unsignedInteger('id_level');
                $table->string('verificationToken', 255)->unique();
                $table->dateTime('createdAt', 0)->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->string('resetPasswordToken', 255)->nullable()->unique();
                $table->dateTime('resetPasswordTokenExpiry', 0)->nullable();
                $table->dateTime('verificationTokenExpiry', 0)->nullable();
                $table->string('nama_usaha', 100)->nullable();
                $table->enum('status_usaha', ['BARU', 'SUDAH_LAMA'])->nullable();
                $table->unsignedInteger('id_kategori_usaha')->nullable();
                $table->foreign('id_kategori_usaha')->references('id_kategori_usaha')->on('tbl_kategori_usaha')->onUpdate('restrict')->onDelete('restrict');
                $table->foreign('id_level')->references('id_level')->on('tbl_level')->onUpdate('restrict');
                $table->index('id_kategori_usaha');
                $table->index('id_level');
            });
        } else {
            Schema::table('tbl_user_temp', function (Blueprint $table) {
                if (!Schema::hasColumn('tbl_user_temp', 'nama_user')) { $table->string('nama_user', 35); }
                if (!Schema::hasColumn('tbl_user_temp', 'username')) { $table->string('username', 45)->unique(); }
                if (!Schema::hasColumn('tbl_user_temp', 'email')) { $table->string('email', 100)->unique(); }
                if (!Schema::hasColumn('tbl_user_temp', 'password')) { $table->string('password', 255); }
                if (!Schema::hasColumn('tbl_user_temp', 'jk')) { $table->enum('jk', ['Laki-laki', 'Perempuan']); }
                if (!Schema::hasColumn('tbl_user_temp', 'nohp')) { $table->string('nohp', 20)->nullable(); }
                if (!Schema::hasColumn('tbl_user_temp', 'id_level')) { $table->unsignedInteger('id_level'); }
                if (!Schema::hasColumn('tbl_user_temp', 'verificationToken')) { $table->string('verificationToken', 255)->unique(); }
                if (!Schema::hasColumn('tbl_user_temp', 'createdAt')) { $table->dateTime('createdAt', 0)->default(DB::raw('CURRENT_TIMESTAMP')); }
                if (!Schema::hasColumn('tbl_user_temp', 'resetPasswordToken')) { $table->string('resetPasswordToken', 255)->nullable()->unique(); }
                if (!Schema::hasColumn('tbl_user_temp', 'resetPasswordTokenExpiry')) { $table->dateTime('resetPasswordTokenExpiry', 0)->nullable(); }
                if (!Schema::hasColumn('tbl_user_temp', 'verificationTokenExpiry')) { $table->dateTime('verificationTokenExpiry', 0)->nullable(); }
                if (!Schema::hasColumn('tbl_user_temp', 'nama_usaha')) { $table->string('nama_usaha', 100)->nullable(); }
                if (!Schema::hasColumn('tbl_user_temp', 'status_usaha')) { $table->enum('status_usaha', ['BARU', 'SUDAH_LAMA'])->nullable(); }
                if (!Schema::hasColumn('tbl_user_temp', 'id_kategori_usaha')) { $table->unsignedInteger('id_kategori_usaha')->nullable(); }
            });
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
        } else {
            Schema::table('tbl_artikel', function (Blueprint $table) {
                if (!Schema::hasColumn('tbl_artikel', 'judul')) { $table->string('judul', 150); }
                if (!Schema::hasColumn('tbl_artikel', 'gambar')) { $table->string('gambar', 100)->nullable(); }
                if (!Schema::hasColumn('tbl_artikel', 'deskripsi_singkat')) { $table->text('deskripsi_singkat')->nullable(); }
                if (!Schema::hasColumn('tbl_artikel', 'isi_lengkap')) { $table->longText('isi_lengkap')->nullable(); }
                if (!Schema::hasColumn('tbl_artikel', 'tanggal_upload')) { $table->date('tanggal_upload'); }
                if (!Schema::hasColumn('tbl_artikel', 'id_user')) { $table->unsignedBigInteger('id_user')->nullable(); }
            });
        }

        if (!Schema::hasTable('tbl_product')) {
            Schema::create('tbl_product', function (Blueprint $table) {
                $table->increments('id_produk');
                $table->string('nama_pelaku', 35)->nullable();
                $table->string('nama_produk', 50);
                $table->string('deskripsi', 500);
                $table->float('harga');
                $table->integer('stok');
                $table->string('gambar', 255);
                $table->string('nohp', 12);
                $table->timestamp('tgl_upload', 0)->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->unsignedBigInteger('id_user')->nullable();
                $table->unsignedInteger('id_kategori_usaha')->nullable();
                $table->enum('status_produk', ['disetujui', 'pending', 'ditolak', 'tidak aktif'])->default('pending');
                $table->foreign('id_user')->references('id')->on('users')->onUpdate('restrict');
                $table->foreign('id_kategori_usaha')->references('id_kategori_usaha')->on('tbl_kategori_usaha')->onUpdate('restrict')->onDelete('restrict');
                $table->index('id_user');
                $table->index('id_kategori_usaha');
            });
        } else {
            Schema::table('tbl_product', function (Blueprint $table) {
                if (!Schema::hasColumn('tbl_product', 'nama_pelaku')) { $table->string('nama_pelaku', 35)->nullable(); }
                if (!Schema::hasColumn('tbl_product', 'nama_produk')) { $table->string('nama_produk', 50); }
                if (!Schema::hasColumn('tbl_product', 'deskripsi')) { $table->string('deskripsi', 500); }
                if (!Schema::hasColumn('tbl_product', 'harga')) { $table->float('harga'); }
                if (!Schema::hasColumn('tbl_product', 'stok')) { $table->integer('stok'); }
                if (!Schema::hasColumn('tbl_product', 'gambar')) { $table->string('gambar', 255); }
                if (!Schema::hasColumn('tbl_product', 'nohp')) { $table->string('nohp', 12); }
                if (!Schema::hasColumn('tbl_product', 'tgl_upload')) { $table->timestamp('tgl_upload', 0)->default(DB::raw('CURRENT_TIMESTAMP')); }
                if (!Schema::hasColumn('tbl_product', 'id_user')) { $table->unsignedBigInteger('id_user')->nullable(); }
                if (!Schema::hasColumn('tbl_product', 'id_kategori_usaha')) { $table->unsignedInteger('id_kategori_usaha')->nullable(); }
                if (!Schema::hasColumn('tbl_product', 'status_produk')) { $table->enum('status_produk', ['disetujui', 'pending', 'ditolak', 'tidak aktif'])->default('pending'); }
            });
        }

        if (!Schema::hasTable('tbl_olshop_link')) {
            Schema::create('tbl_olshop_link', function (Blueprint $table) {
                $table->increments('id_link');
                $table->unsignedInteger('id_produk');
                $table->string('nama_platform', 50)->nullable();
                $table->text('url');
                $table->foreign('id_produk')->references('id_produk')->on('tbl_product')->onDelete('cascade');
                $table->index('id_produk');
            });
        } else {
            Schema::table('tbl_olshop_link', function (Blueprint $table) {
                if (!Schema::hasColumn('tbl_olshop_link', 'id_produk')) { $table->unsignedInteger('id_produk'); }
                if (!Schema::hasColumn('tbl_olshop_link', 'nama_platform')) { $table->string('nama_platform', 50)->nullable(); }
                if (!Schema::hasColumn('tbl_olshop_link', 'url')) { $table->text('url'); }
            });
        }

        if (!Schema::hasTable('sub_sektors')) {
            Schema::create('sub_sektors', function (Blueprint $table) {
                $table->unsignedBigInteger('id', true);
                $table->string('title', 255);
                $table->string('slug', 255)->unique();
                $table->timestamps(0);
            });
        } else {
            Schema::table('sub_sektors', function (Blueprint $table) {
                if (!Schema::hasColumn('sub_sektors', 'title')) { $table->string('title', 255); }
                if (!Schema::hasColumn('sub_sektors', 'slug')) { $table->string('slug', 255)->unique(); }
                if (!Schema::hasColumn('sub_sektors', 'created_at') && !Schema::hasColumn('sub_sektors', 'updated_at')) { $table->timestamps(0); }
            });
        }

        if (!Schema::hasTable('katalogs')) {
            Schema::create('katalogs', function (Blueprint $table) {
                $table->unsignedBigInteger('id', true);
                $table->unsignedBigInteger('sub_sektor_id');
                $table->string('title', 255);
                $table->string('slug', 255)->unique();
                $table->string('produk', 255);
                $table->decimal('harga', 12, 2);
                $table->longText('content');
                $table->string('no_hp', 255)->nullable();
                $table->string('instagram', 255)->nullable();
                $table->string('shopee', 255)->nullable();
                $table->string('tokopedia', 255)->nullable();
                $table->string('lazada', 255)->nullable();
                $table->timestamps(0);
                $table->foreign('sub_sektor_id')->references('id')->on('sub_sektors')->onDelete('cascade');
                $table->index('sub_sektor_id');
            });
        } else {
            Schema::table('katalogs', function (Blueprint $table) {
                if (!Schema::hasColumn('katalogs', 'sub_sektor_id')) { $table->unsignedBigInteger('sub_sektor_id'); }
                if (!Schema::hasColumn('katalogs', 'title')) { $table->string('title', 255); }
                if (!Schema::hasColumn('katalogs', 'slug')) { $table->string('slug', 255)->unique(); }
                if (!Schema::hasColumn('katalogs', 'produk')) { $table->string('produk', 255); }
                if (!Schema::hasColumn('katalogs', 'harga')) { $table->decimal('harga', 12, 2); }
                if (!Schema::hasColumn('katalogs', 'content')) { $table->longText('content'); }
                if (!Schema::hasColumn('katalogs', 'no_hp')) { $table->string('no_hp', 255)->nullable(); }
                if (!Schema::hasColumn('katalogs', 'instagram')) { $table->string('instagram', 255)->nullable(); }
                if (!Schema::hasColumn('katalogs', 'shopee')) { $table->string('shopee', 255)->nullable(); }
                if (!Schema::hasColumn('katalogs', 'tokopedia')) { $table->string('tokopedia', 255)->nullable(); }
                if (!Schema::hasColumn('katalogs', 'lazada')) { $table->string('lazada', 255)->nullable(); }
                if (!Schema::hasColumn('katalogs', 'created_at') && !Schema::hasColumn('katalogs', 'updated_at')) { $table->timestamps(0); }
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('katalogs');
        Schema::dropIfExists('sub_sektors');
        Schema::dropIfExists('tbl_olshop_link');
        Schema::dropIfExists('tbl_product');
        Schema::dropIfExists('tbl_artikel');
        Schema::dropIfExists('tbl_user_temp');
        Schema::dropIfExists('users');
        Schema::dropIfExists('tbl_kategori_usaha');
        Schema::dropIfExists('tbl_level');
    }
};
