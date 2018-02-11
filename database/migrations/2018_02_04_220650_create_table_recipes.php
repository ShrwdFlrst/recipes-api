<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRecipes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->primary('id');
            $table->unsignedInteger('id');
            $table->timestamps();
            $table->enum('box_type', ['vegetarian', 'gourmet']);

            $table->string('title');
            $table->string('slug');
            $table->string('short_title');

            $table->text('marketing_description');
            $table->integer('calories_kcal');
            $table->integer('protein_grams');
            $table->integer('fat_grams');
            $table->integer('carbs_grams');

            $table->string('bulletpoint1');
            $table->string('bulletpoint2');
            $table->string('bulletpoint3');

            $table->enum('recipe_diet_type_id', ['meat', 'fish', 'vegetarian']);
            $table->enum('season', ['all']);
            $table->string('base', 255);
            $table->enum('protein_source', ['beef', 'seafood', 'pork', 'cheese', 'chicken', 'eggs', 'fish']);
            $table->integer('preparation_time_minutes');
            $table->integer('shelf_life_days');
            $table->string('equipment_needed', 255);
            $table->string('origin_country');
            $table->enum('recipe_cuisine', ['asian', 'italian', 'british', 'mediterranean', 'mexican']);
            $table->text('in_your_box');
            $table->integer('gousto_reference');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
