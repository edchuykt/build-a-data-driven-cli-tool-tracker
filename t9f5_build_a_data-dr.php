<?php

// Define a Tracker class to manage tools
class Tracker {
  private $tools = [];

  public function addTool($name, $description, $command) {
    $this->tools[] = [
      'name' => $name,
      'description' => $description,
      'command' => $command
    ];
  }

  public function getTools() {
    return $this->tools;
  }

  public function executeTool($name) {
    foreach ($this->tools as $tool) {
      if ($tool['name'] === $name) {
        system($tool['command']);
        return;
      }
    }
    echo "Tool not found.\n";
  }
}

// Define a CLI interface class
class CLI {
  private $tracker;

  public function __construct(Tracker $tracker) {
    $this->tracker = $tracker;
  }

  public function run() {
    while (true) {
      $this->displayMenu();
      $input = trim(fgets(STDIN));
      $this->handleInput($input);
    }
  }

  private function displayMenu() {
    echo "Tool Tracker\n";
    echo "----------------\n";
    echo "1. List tools\n";
    echo "2. Add tool\n";
    echo "3. Execute tool\n";
    echo "4. Quit\n";
    echo "----------------\n";
    echo "Enter choice: ";
  }

  private function handleInput($input) {
    switch ($input) {
      case '1':
        $this->listTools();
        break;
      case '2':
        $this->addTool();
        break;
      case '3':
        $this->executeTool();
        break;
      case '4':
        exit;
      default:
        echo "Invalid choice.\n";
    }
  }

  private function listTools() {
    $tools = $this->tracker->getTools();
    foreach ($tools as $tool) {
      echo "$tool[name]: $tool[description]\n";
    }
  }

  private function addTool() {
    echo "Enter tool name: ";
    $name = trim(fgets(STDIN));
    echo "Enter tool description: ";
    $description = trim(fgets(STDIN));
    echo "Enter tool command: ";
    $command = trim(fgets(STDIN));
    $this->tracker->addTool($name, $description, $command);
  }

  private function executeTool() {
    echo "Enter tool name to execute: ";
    $name = trim(fgets(STDIN));
    $this->tracker->executeTool($name);
  }
}

// Create a tracker instance
$tracker = new Tracker();

// Create a CLI instance
$cli = new CLI($tracker);

// Run the CLI
$cli->run();