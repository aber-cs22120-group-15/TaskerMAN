<?php

class TaskTest extends PHPUnit_Framework_TestCase {
	
	protected $task;
	
	protected function setUp(){
		$this->task = new TaskerMAN\Application\Task();
	}

	/**
	 * Test date validation function
	 */
	public function testValidateDate(){

		$dates = array(

			'2012-08-15' => true,
			'2012-08-40' => false, // Day 40 does not exist
			'08-04-2012' => false, // Wrong format
			'08/04/2012' => false, // Wrong format
			'08/04/2012 15:24:41' => false // Contains time
		);

		foreach ($dates as $date => $expected){
			$test = $this->task->validateDate($date);
			$this->assertEquals($test, $expected);
		}

	}

	/**
	 * Test date validation of setDueBy()
	 */
	public function testSetDueBy(){

		// Check that it will accept a valid date in the future
		$date = date('Y-m-d', time() + (86400 * 2));
		$result = $this->task->setDueBy($date);
		$this->assertTrue($result);

		// Check due by was set correctly
		$this->assertEquals($date, $this->task->due_by);
	}

	/**
	 * Test task creation
	 */
	public function testCreation(){

		$this->task->setDueBy(date('Y-m-d', time() + (86400 * 2)));
		$this->assertEquals($this->task->due_by, date('Y-m-d', time() + (86400 * 2)));

		$this->task->setCreatedByUser(1);
		$this->assertEquals($this->task->created_uid, 1);

		$this->task->setAssignee(1);
		$this->assertEquals($this->task->assignee_uid, 1);

		$this->task->setStatus(1);
		$this->assertEquals($this->task->status, 1);

		$this->task->setTitle('PHPUnit Testing');
		$this->assertEquals($this->task->title, 'PHPUnit Testing');

		$this->task->createStep('Write some unit tests');

		$this->task->save();

		$this->loadTasks($this->task->id);
		$this->deleteTask($this->task->id);

	}

	/**
	 * Test task loading
	 */
	public function loadTasks($id){
		$load_task = new TaskerMAN\Application\Task($id);
		
		$this->assertEquals($load_task->created_uid, 1);
		$this->assertEquals($load_task->assignee_uid, 1);
		$this->assertEquals($load_task->status, 1);
		$this->assertEquals($load_task->title, 'PHPUnit Testing');

		// Get steps
		$steps = $load_task->getSteps();
		$this->assertEquals($steps[0]['title'], 'Write some unit tests');

	}

	/**
	 * Delete task
	 */
	public function deleteTask($id){

		$query = new TaskerMAN\Core\DBQuery("DELETE FROM `tasks` 
			WHERE `id` = ?
			LIMIT 1
		");

		$query->execute($id);


		$query = new TaskerMAN\Core\DBQuery("DELETE FROM `steps`
			WHERE `task_id` = ?
		");

		$query->execute($id);
	}

}