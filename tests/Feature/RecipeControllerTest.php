<?php

namespace Tests\Feature;

use App\Csv\Parser;
use App\Recipe;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tests\TestCase;

class RecipeControllerTest extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;

    /**
     * Test viewing the list of recipes
     */
    public function testIndexRecipesSuccess()
    {
        $this->seed('RecipeTableSeeder');
        $response = $this->get('/api/recipes');
        $json = $response->json();
        $data = $json['data'];

        $expectedCount = 5;
        $this->assertEquals($expectedCount, count($data));

        // We only want the first X items from the CSV since that's what we're paginating
        $csv = $this->getCsvData();
        $csv = array_slice($csv, 0, $expectedCount);

        // Check each value from the CSV against what's returned from the endpoint
        foreach ($csv as $k => $expected) {
            foreach ($expected as $item => $value) {
                $this->assertEquals($value, $data[$k][$item]);
            }
        }
    }

    /**
     * Test paginating the list of recipes
     */
    public function testIndexRecipesPaginationSuccess()
    {
        $this->seed('RecipeTableSeeder');
        $response = $this->get('/api/recipes');
        $json = $response->json();
        $csv = $this->getCsvData();

        // We expect that there's another page of results
        $expectedNextUrl = 'http://localhost/api/recipes?page=2';
        $this->assertEquals($expectedNextUrl, $json['links']['next']);

        // And that there will be some pagination meta data
        $expectedCurrentPage = 1;
        $expectedPerPage = 5;
        $expectedTotal = count($csv);
        $this->assertEquals($expectedCurrentPage, $json['meta']['current_page']);
        $this->assertEquals($expectedPerPage, $json['meta']['per_page']);
        $this->assertEquals($expectedTotal, $json['meta']['total']);

        // Following the next URL we should get the data from the CSV
        $response = $this->get($json['links']['next']);
        $json = $response->json();
        $data = $json['data'];
        // Paginate the csv as well
        $csv = array_slice($csv, $expectedPerPage);

        // Check each value from the CSV against what's returned from the endpoint
        foreach ($csv as $k => $expected) {
            foreach ($expected as $item => $value) {
                $this->assertEquals($value, $data[$k][$item]);
            }
        }
    }

    /**
     * Test inserting a new recipe
     */
    public function testCreateRecipeSuccess()
    {
        $recipe = $this->getCsvData()[0];
        $id = $recipe['id'];
        // We can't set an ID when creating Recipes since it's an autoincrement column.
        unset($recipe['id']);
        $response = $this->json(Request::METHOD_POST, '/api/recipes', $recipe);

        // Check that the correct status and json are returned
        $response
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJson($recipe)
        ;

        // Check that recipe exists in the db
        $dbRecipe = Recipe::all()[0];
        $this->assertArraySubset($recipe, $dbRecipe->toArray());
    }

    /**
     * Test updating a recipe
     */
    public function testUpdateRecipeSuccess()
    {
        $data = $this->getCsvData();
        $existingRecipe = Recipe::create($data[0]);
        $newRecipeData = $data[1];

        // Ignore fields we won't be updating
        unset($newRecipeData['id']);
        unset($newRecipeData['updated_at']);

        $response = $this->json(Request::METHOD_PUT, '/api/recipes/' . $existingRecipe->id, $newRecipeData);

        // Check that the correct status and json are returned
        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJson($newRecipeData)
        ;

        // Check that recipe exists in the db
        $dbRecipe = Recipe::all()[0];
        $this->assertArraySubset($newRecipeData, $dbRecipe->toArray());
    }

    /**
     * @return array
     */
    private function getCsvData()
    {
        $parser = new Parser();
        // We could type out this data but for convenience using the test data
        $path = public_path() . '/../database/recipe-data.csv';

        return $parser->toArray($path);
    }
}
