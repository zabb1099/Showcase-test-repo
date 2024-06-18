<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use Illuminate\Support\Facades\Http;

class ItPortalTest extends TestCase {

    public function testAccessLoginPage()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function testLogUserInOnTheLoginPageCorrect()
    {
        $response = $this->post('/oauth/token', ['grant_type' => 'password', 'client_id' => '6', 'client_secret' => env('CLIENT_SECRET'), 'username' => env('USERNAME_SECRET'), 'password' => env('PASSWORD_SECRET'), 'scope' => '*']);;
        $this->assertNotEmpty(json_decode($response->getContent())->token_type);
        $this->assertNotEmpty(json_decode($response->getContent())->expires_in);
        $this->assertNotEmpty(json_decode($response->getContent())->access_token);
        $this->assertNotEmpty(json_decode($response->getContent())->refresh_token);
        $response->assertStatus(200);
    }

    public function testLogUserInOnTheLoginClientSecretIncorrect()
    {
        $response = $this->post('/oauth/token', ['grant_type' => 'password', 'client_id' => '6', 'client_secret' => 'notvalid', 'username' => env('USERNAME_SECRET'), 'password' => env('PASSWORD_SECRET'), 'scope' => '*']);;
        $this->assertEquals(json_decode($response->getContent())->error, 'invalid_client');
        $this->assertEquals(json_decode($response->getContent())->error_description, 'Client authentication failed');
        $this->assertEquals(json_decode($response->getContent())->message, 'Client authentication failed');
        $response->assertStatus(401);
    }

    public function testLogUserInOnTheLoginUsernameIncorrect()
    {
        $response = $this->post('/oauth/token', ['grant_type' => 'password', 'client_id' => '6', 'client_secret' => env('CLIENT_SECRET'), 'username' => 'notvalid', 'password' => env('PASSWORD_SECRET'), 'scope' => '*']);;
        $this->assertEquals(json_decode($response->getContent())->error, 'invalid_grant');
        $this->assertEquals(json_decode($response->getContent())->error, 'invalid_grant');
//        dd(json_decode($response->getContent())->message);
        $this->assertEquals(json_decode($response->getContent())->error_description, 'The user credentials were incorrect.');
        $this->assertEquals(json_decode($response->getContent())->message, 'The user credentials were incorrect.');
        $response->assertStatus(400);
    }

    public function testLogUserInOnTheLoginPasswordIncorrect()
    {
        $response = $this->post('/oauth/token', ['grant_type' => 'password', 'client_id' => '6', 'client_secret' => env('CLIENT_SECRET'), 'username' => env('USERNAME_SECRET'), 'password' => 'notvalid', 'scope' => '*']);;
        $this->assertEquals(json_decode($response->getContent())->error, 'invalid_grant');
        $this->assertEquals(json_decode($response->getContent())->error_description, 'The user credentials were incorrect.');
        $this->assertEquals(json_decode($response->getContent())->message, 'The user credentials were incorrect.');
        $response->assertStatus(400);
    }

    public function testLogoutFromSession()
    {
        $login = $this->post('/oauth/token', ['grant_type' => 'password', 'client_id' => '6', 'client_secret' => env('CLIENT_SECRET'), 'username' => env('USERNAME_SECRET'), 'password' => env('PASSWORD_SECRET'), 'scope' => '*']);;
        $token = json_decode($login->getContent())->access_token;
        $logout = $this->get('/logout', ['headers' => ['Authorization' => 'Bearer ' . $token]]);
        $logout->assertStatus(302);
    }

    public function testAccessKnowledgeBasePage()
    {
        $response = $this->get('/it-portal/knowledge-base');

        $response->assertStatus(200);
    }

    public function testGetKnowledgeBase()
    {
        $user = \App\Models\User::where('USR_Login', env('USERNAME_SECRET'))->first();

        $response = $this->actingAs($user, 'api')->get('/api/knowledge-base');

        $this->assertEquals($user->UST_ID, 1);
        $this->assertTrue($user->can('viewKnowledgeBase'));
        $this->assertEquals(json_decode($response->getContent())->knowledgeBase->per_page, 15);
        $this->assertIsObject(json_decode($response->getContent())->knowledgeBase->data[0]);
        $response->assertStatus(200);
    }

    public function testPutKnowledgeBase()
    {
        $user = \App\Models\User::where('USR_Login', env('USERNAME_SECRET'))->first();

        $knowledgeBase = \App\Models\ITPortal\KnowledgeBase::whereNull('Date_Deleted')->orderBy('Date_Created ', 'DESC')->first();

        $postInfoPrev = [
            'Short_Name' => 'test_prev',
            'ITP_ID' => 2,
            'TEAM_ID' => 2,
            'Issue_Type' => 'test_prev',
            'Issue_Description' => 'test_prev',
            'Solution_Description' => 'test_prev',
            'Created_By' => $user->USR_ID,
            'Date_Created' => date("Y/m/d H:i:s"),
        ];

        $response = $this->actingAs($user, 'api')->put('/api/knowledge-base/' . $knowledgeBase->ITL_ID, $postInfoPrev);

        $response->assertStatus(201);
        $this->assertEquals(json_decode($response->getContent())->ITP_ID, 2);
        $this->assertEquals(json_decode($response->getContent())->TEAM_ID, 2);
        $this->assertEquals(json_decode($response->getContent())->Issue_Type, 'test_prev');
        $this->assertEquals(json_decode($response->getContent())->Short_Name, 'test_prev');
        $this->assertEquals(json_decode($response->getContent())->Issue_Description, 'test_prev');
        $this->assertEquals(json_decode($response->getContent())->Solution_Description, 'test_prev');
        $this->assertEquals(json_decode($response->getContent())->Created_By, $user->USR_ID);

        $postInfoAfter = [
            'Short_Name' => 'test_after',
            'ITP_ID' => 2,
            'TEAM_ID' => 2,
            'Issue_Type' => 'test_after',
            'Issue_Description' => 'test_after',
            'Solution_Description' => 'test_after',
            'Created_By' => $user->USR_ID,
            'Date_Created' => date("Y/m/d H:i:s"),
        ];

        $response = $this->actingAs($user, 'api')->put('/api/knowledge-base/' . $knowledgeBase->ITL_ID, $postInfoAfter);
        $response->assertStatus(201);
        $this->assertEquals(json_decode($response->getContent())->ITP_ID, 2);
        $this->assertEquals(json_decode($response->getContent())->TEAM_ID, 2);
        $this->assertEquals(json_decode($response->getContent())->Issue_Type, 'test_after');
        $this->assertEquals(json_decode($response->getContent())->Short_Name, 'test_after');
        $this->assertEquals(json_decode($response->getContent())->Issue_Description, 'test_after');
        $this->assertEquals(json_decode($response->getContent())->Solution_Description, 'test_after');
        $this->assertEquals(json_decode($response->getContent())->Created_By, $user->USR_ID);

    }

    public function testPutKnowledgeBaseNotPassingValidation()
    {
        $user = \App\Models\User::where('USR_Login', env('USERNAME_SECRET'))->first();

        $knowledgeBase = \App\Models\ITPortal\KnowledgeBase::whereNull('Date_Deleted')->orderBy('Date_Created ', 'DESC')->first();

        $postInfoPrev = [
            'Short_Name' => 4,
        ];

        $response = $this->actingAs($user, 'api')->put('/api/knowledge-base/' . $knowledgeBase->ITL_ID, $postInfoPrev);
        $response->assertStatus(302);
        $this->assertNull(json_decode($response->getContent()));
    }


    public function testAccessOfficeUsersPage()
    {
        $response = $this->get('/it-portal/office-users');

        $response->assertStatus(200);
    }

    public function testGetOfficeUsers()
    {
        $user = \App\Models\User::where('USR_Login', env('USERNAME_SECRET'))->first();

        $response = $this->actingAs($user, 'api')->get('/api/asset-register');

        $this->assertEquals($user->UST_ID, 1);
        $this->assertTrue($user->can('viewOfficeUser'));
        $this->assertEquals(json_decode($response->getContent())->assetRegister->per_page, 15);
        $this->assertIsObject(json_decode($response->getContent())->assetRegister->data[0]);
        $response->assertStatus(200);
    }

    public function testPutOfficeUsers()
    {
        $user = \App\Models\User::where('USR_Login', env('USERNAME_SECRET'))->first();

        $officeUser = \App\Models\ITPortal\OfficeUser::whereNull('Date_Deleted')->orderBy('AddedOn ', 'DESC')->first();
        $officeUserPrev = [
            'Version' => 'test_prev',
            'Key' => 'test_prev',
            'email' => 'test_prev@test_prev.com',
            'password' => 'test_prev',
            'PCName' => 'test_prev',
            'UserName' => 'test_prev',
            'LastUpdatedBy' => $user->USR_ID,
            'LastUpdatedOn' => date("Y/m/d H:i:s"),
            'Notes' => 'test_prev'
        ];

        $response = $this->actingAs($user, 'api')->put('/api/office-users/' . $officeUser->ID, $officeUserPrev);


        $response->assertStatus(201);
        $this->assertEquals(json_decode($response->getContent())->ID, $officeUser->ID);
        $this->assertEquals(json_decode($response->getContent())->Version, 'test_prev');
        $this->assertEquals(json_decode($response->getContent())->Key, 'test_prev');
        $this->assertEquals(json_decode($response->getContent())->email, 'test_prev@test_prev.com');
        $this->assertEquals(json_decode($response->getContent())->password, 'test_prev');
        $this->assertEquals(json_decode($response->getContent())->PCName, 'test_prev');
        $this->assertEquals(json_decode($response->getContent())->UserName, 'test_prev');
        $this->assertEquals(json_decode($response->getContent())->LastUpdatedBy, $user->USR_ID);


        $officeUserAfter = [
            'Version' => 'test_after',
            'Key' => 'test_after',
            'email' => 'test_after@test_after.com',
            'password' => 'test_after',
            'PCName' => 'test_after',
            'UserName' => 'test_after',
            'LastUpdatedBy' => $user->USR_ID,
            'LastUpdatedOn' => date("Y/m/d H:i:s"),
            'Notes' => 'test_after'
        ];


        $response = $this->actingAs($user, 'api')->put('/api/office-users/' . $officeUser->ID, $officeUserAfter);
        $response->assertStatus(201);
        $this->assertEquals(json_decode($response->getContent())->ID, $officeUser->ID);
        $this->assertEquals(json_decode($response->getContent())->Version, 'test_after');
        $this->assertEquals(json_decode($response->getContent())->Key, 'test_after');
        $this->assertEquals(json_decode($response->getContent())->email, 'test_after@test_after.com');
        $this->assertEquals(json_decode($response->getContent())->password, 'test_after');
        $this->assertEquals(json_decode($response->getContent())->PCName, 'test_after');
        $this->assertEquals(json_decode($response->getContent())->UserName, 'test_after');
        $this->assertEquals(json_decode($response->getContent())->LastUpdatedBy, $user->USR_ID);


    }


    public function testAccessAssetRegisterPage()
    {
        $response = $this->get('/it-portal/asset-register');

        $response->assertStatus(200);
    }

    public function testPutAssetRegister()
    {
        $user = \App\Models\User::where('USR_Login', env('USERNAME_SECRET'))->first();
        $assetRegister = \App\Models\ITPortal\AssetRegister::whereNull('Date_Deleted')->orderBy('Date_Added', 'DESC')->first();
        $assetRegisterPrev = [
            'Name' => 'test_prev',
            'Asset_Type' => 'test_prev',
            'Model' => 'test_prev',
            'Serial_No' => 'test_prev',
            'ZeroTier_IP_LPT' => 'test_prev',
            'Zero_Tier_IP_PC' => 'test_prev',
            'Last_Updated_On' => date("Y/m/d H:i:s"),
            'Last_Updated_By' => $user->USR_ID,
            'EMP_ID' => $user->USR_ID,
            'EmployeeName' => $user->USR_Full_Name,
            'LP_username' => 'test_prev',
            'LP_password' => 'test_prev',
        ];

        $response = $this->actingAs($user, 'api')->put('/api/asset-register/' . $assetRegister->ID, $assetRegisterPrev);

        $response->assertStatus(201);
        $this->assertEquals(json_decode($response->getContent())->ID, $assetRegister->ID);
        $this->assertEquals(json_decode($response->getContent())->Name, 'test_prev');
        $this->assertEquals(json_decode($response->getContent())->Asset_Type, 'test_prev');
        $this->assertEquals(json_decode($response->getContent())->Model, 'test_prev');
        $this->assertEquals(json_decode($response->getContent())->Serial_No, 'test_prev');
        $this->assertEquals(json_decode($response->getContent())->ZeroTier_IP_LPT, 'test_prev');
        $this->assertEquals(json_decode($response->getContent())->Zero_Tier_IP_PC, 'test_prev');
        $this->assertEquals(json_decode($response->getContent())->Last_Updated_By, $user->USR_ID);
        $this->assertEquals(json_decode($response->getContent())->EMP_ID, $user->USR_ID);
        $this->assertEquals(json_decode($response->getContent())->EmployeeName, $user->USR_Full_Name);


        $assetRegisterAfter = [
            'Name' => 'test_after',
            'Asset_Type' => 'test_after',
            'Model' => 'test_after',
            'Serial_No' => 'test_after',
            'ZeroTier_IP_LPT' => 'test_after',
            'Zero_Tier_IP_PC' => 'test_after',
            'Last_Updated_On' => date("Y/m/d H:i:s"),
            'Last_Updated_By' => $user->USR_ID,
            'EMP_ID' => $user->USR_ID,
            'EmployeeName' => $user->USR_Full_Name,
            'LP_username' => 'test_after',
            'LP_password' => 'test_after',
        ];

        $response = $this->actingAs($user, 'api')->put('/api/asset-register/' . $assetRegister->ID, $assetRegisterAfter);

        $response->assertStatus(201);
        $this->assertEquals(json_decode($response->getContent())->ID, $assetRegister->ID);
        $this->assertEquals(json_decode($response->getContent())->Name, 'test_after');
        $this->assertEquals(json_decode($response->getContent())->Asset_Type, 'test_after');
        $this->assertEquals(json_decode($response->getContent())->Model, 'test_after');
        $this->assertEquals(json_decode($response->getContent())->Serial_No, 'test_after');
        $this->assertEquals(json_decode($response->getContent())->ZeroTier_IP_LPT, 'test_after');
        $this->assertEquals(json_decode($response->getContent())->Zero_Tier_IP_PC, 'test_after');
        $this->assertEquals(json_decode($response->getContent())->Last_Updated_By, $user->USR_ID);
        $this->assertEquals(json_decode($response->getContent())->EMP_ID, $user->USR_ID);
        $this->assertEquals(json_decode($response->getContent())->EmployeeName, $user->USR_Full_Name);
    }

    public function testGetAssetRegister()
    {
        $user = \App\Models\User::where('USR_Login', env('USERNAME_SECRET'))->first();
        $response = $this->actingAs($user, 'api')->get('/api/user-stations');
        $this->assertEquals($user->UST_ID, 1);
        $this->assertTrue($user->can('viewAssetRegister'));
        $this->assertEquals(json_decode($response->getContent())->userStation->per_page, 15);
        $this->assertIsObject(json_decode($response->getContent())->userStation->data[0]);
        $response->assertStatus(200);
    }

    public function testAccessUserStationPage()
    {
        $response = $this->get('/it-portal/user-station');

        $response->assertStatus(200);
    }

    public function testPutUserStation()
    {
        $user = \App\Models\User::where('USR_Login', env('USERNAME_SECRET'))->first();

        $userStation = \App\Models\ITPortal\UserStation::whereNull('Date_Deleted')->orderBy('AddedOn', 'DESC')->first();

        $userStationPrev = [
            'DeskName' => 'test_prev',
            'ComputerName' => 'test_prev',
            'AssignedTo' => $user->USR_ID,
            'BankNo' => 'test_prev',
            'PCNo' => 'test_prev',
            'OS' => 'test_prev',
            'RAM' => 'test_prev',
            'Processor' => 'test_prev',
            'MSOfficeVersion' => 'test_prev',
            'IsDualMonitors' => '1',
            'Notes' => 'test_prev',
            'LastUpdatedBy' => $user->USR_ID,
            'LastUpdatedOn' => date("Y/m/d H:i:s"),
        ];

        $response = $this->actingAs($user, 'api')->put('/api/user-stations/' . $userStation->ID, $userStationPrev);
        $response->assertStatus(201);
        $this->assertEquals(json_decode($response->getContent())->ID, $userStation->ID);
        $this->assertEquals(json_decode($response->getContent())->DeskName, 'test_prev');
        $this->assertEquals(json_decode($response->getContent())->ComputerName, 'test_prev');
        $this->assertEquals(json_decode($response->getContent())->AssignedTo, $user->USR_ID);
        $this->assertEquals(json_decode($response->getContent())->BankNo, 'test_prev');
        $this->assertEquals(json_decode($response->getContent())->PCNo, 'test_prev');
        $this->assertEquals(json_decode($response->getContent())->OS, 'test_prev');
        $this->assertEquals(json_decode($response->getContent())->RAM, 'test_prev');
        $this->assertEquals(json_decode($response->getContent())->Processor, 'test_prev');
        $this->assertEquals(json_decode($response->getContent())->MSOfficeVersion, 'test_prev');
        $this->assertEquals(json_decode($response->getContent())->IsDualMonitors, '1');
        $this->assertEquals(json_decode($response->getContent())->Notes, 'test_prev');

        $userStationAfter = [
            'DeskName' => 'test_after',
            'ComputerName' => 'test_after',
            'AssignedTo' => $user->USR_ID,
            'BankNo' => 'test_after',
            'PCNo' => 'test_after',
            'OS' => 'test_after',
            'RAM' => 'test_after',
            'Processor' => 'test_after',
            'MSOfficeVersion' => 'test_after',
            'IsDualMonitors' => '1',
            'Notes' => 'test_after',
            'LastUpdatedBy' => $user->USR_ID,
            'LastUpdatedOn' => date("Y/m/d H:i:s"),
        ];

        $response = $this->actingAs($user, 'api')->put('/api/user-stations/' . $userStation->ID, $userStationAfter);

        $response->assertStatus(201);
        $this->assertEquals(json_decode($response->getContent())->ID, $userStation->ID);
        $this->assertEquals(json_decode($response->getContent())->DeskName, 'test_after');
        $this->assertEquals(json_decode($response->getContent())->ComputerName, 'test_after');
        $this->assertEquals(json_decode($response->getContent())->AssignedTo, $user->USR_ID);
        $this->assertEquals(json_decode($response->getContent())->BankNo, 'test_after');
        $this->assertEquals(json_decode($response->getContent())->PCNo, 'test_after');
        $this->assertEquals(json_decode($response->getContent())->OS, 'test_after');
        $this->assertEquals(json_decode($response->getContent())->RAM, 'test_after');
        $this->assertEquals(json_decode($response->getContent())->Processor, 'test_after');
        $this->assertEquals(json_decode($response->getContent())->MSOfficeVersion, 'test_after');
        $this->assertEquals(json_decode($response->getContent())->IsDualMonitors, '1');
        $this->assertEquals(json_decode($response->getContent())->Notes, 'test_after');
    }

    public function testGetUserStation()
    {
        $user = \App\Models\User::where('USR_Login', env('USERNAME_SECRET'))->first();

        $response = $this->actingAs($user, 'api')->get('/api/user-stations');
        $this->assertEquals($user->UST_ID, 1);
        $this->assertTrue($user->can('viewUserStation'));
        $this->assertEquals(json_decode($response->getContent())->userStation->per_page, 15);
        $this->assertIsObject(json_decode($response->getContent())->userStation->data[0]);
        $response->assertStatus(200);
    }

    public function testAccessNotFoundPage()
    {
        $response = $this->get('/notFound');

        $response->assertStatus(200);
    }
}
