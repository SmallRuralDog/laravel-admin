<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('system_dept', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('部门名称');
            $table->integer('parent_id')->default(0)->comment('父级ID')->index();
            $table->integer('order')->default(0)->comment('排序');
            $table->timestamps();
        });

        Schema::create('system_menu', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['dir', 'menu', 'permission'])->default('dir')->comment('类型');
            $table->integer('parent_id')->default(0)->comment('父级ID')->index();
            $table->string('path')->nullable()->default('')->comment('路径')->index();
            $table->string('name')->default('')->comment('菜单名称');
            $table->string('permission')->nullable()->default('')->comment('权限标识')->index();
            $table->string('icon')->nullable()->default('')->comment('图标');
            $table->integer('order')->default(0)->comment('排序');
            $table->boolean('show')->default(true)->comment('是否显示');
            $table->boolean('status')->default(true)->comment('状态');
            $table->boolean('is_ext')->default(false)->comment('是否外链');
            $table->string('ext_open_mode', 32)->default('')->comment('外链打开方式');
            $table->string('active_menu')->default('')->comment('激活菜单');
            $table->timestamps();
        });

        Schema::create('system_role',function (Blueprint $table){
            $table->id();
            $table->string('name')->comment('角色名称');
            $table->string('slug')->comment('角色标识')->unique();
            $table->string('data_permissions_type',32)->default('')->comment('数据权限类型');
            $table->timestamps();
        });

        Schema::create('system_user', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique()->comment('用户名')->unique();
            $table->string('password')->comment('密码');
            $table->string('name')->default('')->comment('姓名');
            $table->string('avatar')->default('')->comment('头像');
            $table->integer('dept_id')->default(0)->comment('部门ID')->index();
            $table->integer('create_user_id')->default(0)->comment('创建人ID')->index();
            $table->boolean('status')->default(true)->comment('状态');
            $table->timestamps();
        });

        Schema::create('system_role_dept', function (Blueprint $table) {
            $table->integer('role_id')->comment('角色ID')->index();
            $table->integer('dept_id')->comment('部门ID')->index();
            $table->primary(['role_id', 'dept_id']);
        });

        Schema::create('system_role_menu', function (Blueprint $table) {
            $table->integer('role_id')->comment('角色ID')->index();
            $table->integer('menu_id')->comment('菜单ID')->index();
            $table->primary(['role_id', 'menu_id']);
        });

        Schema::create('system_role_user', function (Blueprint $table) {
            $table->integer('role_id')->comment('角色ID')->index();
            $table->integer('user_id')->comment('用户ID')->index();
            $table->primary(['role_id', 'user_id']);
        });

        Schema::create('system_setting', function (Blueprint $table) {
            $table->string('slug')->primary();
            $table->json('value');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_dept');
        Schema::dropIfExists('system_menu');
        Schema::dropIfExists('system_role');
        Schema::dropIfExists('system_user');
        Schema::dropIfExists('system_role_dept');
        Schema::dropIfExists('system_role_menu');
        Schema::dropIfExists('system_role_user');
        Schema::dropIfExists('system_setting');
    }
};
