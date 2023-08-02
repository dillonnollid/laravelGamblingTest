<?php
namespace Tests\Feature;

use App\Models\Affiliate;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class AffiliateControllerTest extends TestCase
{

    /**
     * Test if the /invite-affiliates route returns the view with matching affiliates.
     * NOTE: Running this test will erase the existing affiliates.txt file
     */
    public function test_invite_affiliates_route_returns_view_with_matching_affiliates()
    {
        //Prepare test data and replace existing affiliates file, coordinates for another address in Dublin
        $affiliateData = '{"latitude": "53.349804", "affiliate_id": 100, "name": "Dillon Rosenkranz", "longitude": "-6.260310"}';
        File::put(storage_path('app/affiliates.txt'), $affiliateData);

        //Run the test
        $response = $this->get('/invite-affiliates');

        //Assertions
        $response->assertStatus(200); // Check if the response is successful
        $response->assertViewIs('invite-affiliates'); // Check if the correct view is returned
        $response->assertViewHas('matchingAffiliates'); // Check if the view has the 'matchingAffiliates' variable

        $matchingAffiliates = $response->viewData('matchingAffiliates');
        $this->assertCount(1, $matchingAffiliates); // Check if the view has one matching affiliate

        $affiliate = $matchingAffiliates[0];
        $this->assertInstanceOf(Affiliate::class, $affiliate); // Check if the matching affiliate is an instance of Affiliate model
        $this->assertSame(100, $affiliate->getID()); // Check if the ID of the matching affiliate is 1
        $this->assertSame('Dillon Rosenkranz', $affiliate->getName()); // Check if the name of the matching affiliate is 'John Doe'
    }

}
