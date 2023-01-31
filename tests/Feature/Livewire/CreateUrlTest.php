<?php

namespace Tests\Feature\Livewire;

use App\Models\Url;
use Tests\TestCase;
use App\Models\User;
use Livewire\Livewire;
use App\Http\Livewire\ShortUrlForm;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateUrlTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_url()
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(ShortUrlForm::class)
            ->set('destination', $destination = 'https://govassist.bamboohr.com/careers/33')
            ->call('submit');

        $this->assertTrue(Url::whereDestination($destination)->exists());
    }

    public function test_destination_is_required()
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(ShortUrlForm::class)
            ->set('destination', '')
            ->call('submit')
            ->assertHasErrors(['destination' => 'required']);
    }
}
