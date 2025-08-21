<?php
namespace Tests\Feature;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Customer;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Desativa middlewares que podem bloquear requisições
        $this->withoutMiddleware([
            \Illuminate\Auth\Middleware\Authenticate::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
        ]);
    }

    /** @test */
    public function it_lists_all_customers()
    {
        Customer::factory()->count(5)->create();
        $response = $this->getJson('/api/customers');

        $response->assertOk();

        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'name', 'email']
            ],
            'links',
            'meta'
        ]);

        $response->assertJsonCount(5, 'data');
    }

    /** @test */
    public function it_creates_a_new_customer()
    {
        $data = [
            'name' => 'Fulano Teste',
            'email' => 'fulano@email.com',
            'phone' => '(81) 99999-9999',
            'city' => 'Recife',
            'state' => 'PE',
            'photo' => 'https://via.placeholder.com/300',
            'age' => 30,
        ];

        $response = $this->postJson('/api/customers', $data);

        $response->assertCreated();
        $this->assertDatabaseHas('customers', ['email' => 'fulano@email.com']);
    }

    /** @test */
    public function it_validates_required_fields()
    {
        $response = $this->postJson('/api/customers', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }

    /** @test */
    public function it_shows_a_single_customer()
    {
        $customer = Customer::factory()->create();
        $response = $this->getJson("/api/customers/{$customer->id}");

        $response->assertOk()
            ->assertJsonPath('data.id', $customer->id);
    }

    /** @test */
    public function it_updates_a_customer()
    {
        $customer = Customer::factory()->create();
        $response = $this->putJson("/api/customers/{$customer->id}", [
            'name' => 'Novo Nome'
        ]);

        $response->assertOk();
        $this->assertDatabaseHas('customers', [
            'id' => $customer->id,
            'name' => 'Novo Nome'
        ]);
    }

    /** @test */
    public function it_deletes_a_customer()
    {
        $customer = Customer::factory()->create();
        $response = $this->deleteJson("/api/customers/{$customer->id}");

        $response->assertNoContent();

        $this->assertSoftDeleted('customers', ['id' => $customer->id]);
    }
}
