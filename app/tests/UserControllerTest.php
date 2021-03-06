<?php
/**
 * Tests the UserController functions that store, edit and delete users 
 * @author  (c) @iLabAfrica, Emmanuel Kitsao, Brian Kiprop, Thomas Mapesa, Anthony Ereng
 */
class UserControllerTest extends TestCase 
{
    /**
    * Initial setup function for tests
    *
    * @return void
    */
    public function setUp(){
        parent::setUp();
        Artisan::call('migrate');
        $this->setVariables();
    }

    /**
     * Contains the testing sample data for the UserController.
     *
     * @return void
     */
    public function setVariables()
    {
    	// Initial sample storage data
		$this->userData = array(
			'username' => 'dotmatrix',
			'email' => 'johxdoe@example.com',
			'full_name' => 'John Dot',
			'gender' => User::FEMALE,
			'designation' => 'LabTechnikan',
            'password' => "goodpassword",
            'password_confirmation' => "goodpassword",
        );

        // Edition sample data
        $this->userDataUpdate = array(
          'email' => 'johndoe@example.com',
          'full_name' => 'John Doe',
          'gender' => User::MALE,
          'designation' => 'LabTechnician',
          'current_password' => 'goodpassword',
          'new_password' => 'newpassword',
          'new_password_confirmation' => 'newpassword',
        );

        // sample login data
        $this->userDataLoginBad = array(
            'username' => 'dotmatrix',
            'password' => 'wrongpassword',
        );

        // sample login data
        $this->userDataLoginGood = array(
            'username' => 'dotmatrix',
            'password' => 'goodpassword',
        );

        // sample login data
        $this->userDataLoginFailsVerification = array(
            'username' => 'dot',
            'password' => 'goo',
        );

    }
	
	/**
	 * Tests the store function in the UserController
	 * @return int $testUserId ID of User stored; used in testUpdate() to identify test for update
	 */    
 	public function testStore() 
	{
        echo "\n\nUSER CONTROLLER TEST\n\n";
        // Store the User
        Input::replace($this->userData);
        $user = new UserController;
        $user->store();

		$userSaved = User::find(1);

		$this->assertEquals($userSaved->username , $this->userData['username']);
		$this->assertEquals($userSaved->email , $this->userData['email']);
		$this->assertEquals($userSaved->name , $this->userData['full_name']);
		$this->assertEquals($userSaved->gender , $this->userData['gender']);
		$this->assertEquals($userSaved->designation , $this->userData['designation']);
	}

  /**
   * Tests the update function in the UserController
   * @param  void
   * @return void
   */
    public function testUpdate()
    {
        // Update the User Types
        Input::replace($this->userData);
        $user = new UserController;
        $user->store();
        Input::replace($this->userDataUpdate);
        $user->update(1);

        $userUpdated = User::find(1);
        $this->assertEquals($userUpdated->email , $this->userDataUpdate['email']);
        $this->assertEquals($userUpdated->name , $this->userDataUpdate['full_name']);
        $this->assertEquals($userUpdated->gender , $this->userDataUpdate['gender']);
        $this->assertEquals($userUpdated->designation , $this->userDataUpdate['designation']);
    }

    /**
    * Tests the updateOwnPassword function in the UserController
    * @param  void
    * @return void
    */
    public function testUpdateOwnPassword()
    {
        // Update the User Types
        Input::replace($this->userData);
        $user = new UserController;
        $user->store();
        Input::replace($this->userDataUpdate);
        $user->updateOwnPassword(1);

        $userUpdated = User::find(1);

        $this->assertTrue(Hash::check($this->userDataUpdate['new_password'], $userUpdated->password));
    }

	/**
   * Tests the update function in the UserController
	 * @param  void
	 * @return void
   */
	public function testDelete()
	{
        Input::replace($this->userData);
        $user = new UserController;
        $user->store();
        $user->delete(1);
		$usersSaved = User::withTrashed()->find(1);

		$this->assertNotNull($usersSaved->deleted_at);
	}

    public function testHandlesFailedLogin()
    {
        Input::replace($this->userData);
        $user = new UserController;
        $user->store();

        $this->action('POST', 'UserController@loginAction', $this->userDataLoginBad);
        $this->assertRedirectedToRoute('user.login');
    }

    public function testHandlesValidLogin()
    {
        Input::replace($this->userData);
        $user = new UserController;
        $user->store();

        $this->action('POST', 'UserController@loginAction', $this->userDataLoginGood);
        $this->assertRedirectedToRoute('user.home');
    }

    public function testHandlesLoginValidation()
    {
        Input::replace($this->userData);
        $user = new UserController;
        $user->store();

        $this->action('POST', 'UserController@loginAction', $this->userDataLoginFailsVerification);
        $this->assertRedirectedToRoute('user.login');
    }
}