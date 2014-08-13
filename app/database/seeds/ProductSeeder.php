<?php
/**
* Seed the DB with the default products
*/
class ProductSeeder extends Seeder {

	public function run()
	{
		DB::table('products')->delete();
		Product::create([
			'flavor_id' => 1,
			'size_id' => 1,
			'ingredients' => "Carbonated Water, Sugar, Citric Acid, Sodium Benzoate (as a preservative), Sodium Citrate, Gum Arabic, Glycerol Ester of Gum Rosin, Natural Flavor, Caffeine and Yellow 5.​",
			'content' => 'Kickapoo Joy Juice 12oz Glass bottle lorem ipsum'
		]);
		Product::create([
			'flavor_id' => 1,
			'size_id' => 2,
			'ingredients' => "Carbonated Water, High Fructose Corn Syrup,Citric Acid, Sodium Benzoate (as a preservative), Sodium Citrate, Gum Arabic, Glycerol Ester of Gum Rosin, Natural Flavor, Caffeine and Yellow 5.",
			'content' => 'Kickapoo Joy Juice slim can lorem ipsum'
		]);
		Product::create([
			'flavor_id' => 1,
			'size_id' => 3,
			'ingredients' => "Carbonated Water, High Fructose Corn Syrup, Citric Acid, Sodium Benzoate (as a preservative), Sodium Citrate, Gum Arabic, Glycerol Ester of Gum Rosin, Natural Flavor, Caffeine and Yellow 5.",
			'content' => 'Kickapoo Joy Juice 1L bottle lorem ipsum'
		]);
		Product::create([
			'flavor_id' => 2,
			'size_id' => 2,
			'ingredients' => "Carbonated Water, High Fructose Corn Syrup, Citric Acid, Sodium Citrate, Natural Flavor, Sodium Benzoate (as a preservative), Caffeine, Caramel Color, Red 40, Gum Acacia and Blue 1",
			'content' => 'Kickapoo Fruit Shine slim can lorem ipsum'
		]);
		Product::create([
			'flavor_id' => 2,
			'size_id' => 3,
			'ingredients' => "Carbonated Water, High Fructose Corn Syrup, Citric Acid, Sodium Citrate, Natural Flavor, Sodium Benzoate (as a preservative), Caffeine, Caramel Color, Red 40, Gum Acacia and Blue 1.",
			'content' => 'Kickapoo Fruit Shine 1L bottle lorem ipsum'
		]);
	}

}