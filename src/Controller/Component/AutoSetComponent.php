<?php
namespace PropertyEnum\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;

class AutoSetComponent extends Component
{
    /**
     * {@inheritDoc}
     */
    public function startup()
    {
        $controller = $this->_registry->getController();

        if (!class_exists('App\Model\Table\\' . $controller->modelClass) . 'Table') {
            return;
        }

        $table = $controller->loadModel();
        $tableAlias = $table->table();
        if (empty($table->enums)) {
            return;
        }
        foreach ($table->enums as $field => $enum) {
            $controller->set(
                Inflector::pluralize(Inflector::variable($field)),
                $table->enum($field)
            );
        }
    }
}
