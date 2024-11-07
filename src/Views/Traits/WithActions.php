<?php

namespace LaravelViews\Views\Traits;

use Exception;
use LaravelViews\Actions\Action;

trait WithActions
{
    /**
     * @param string $action Action's name
     * @param string $id Model's id
     */
    public function executeAction($actionId, $actionableItemId)
    {
        $this->executeActionHandler($actionId, $actionableItemId);
    }

    public function executeBulkAction($action)
    {
        $this->executeActionHandler($action);
    }

    private function executeActionHandler($actionId, $actionableItemId = null)
    {
        $action = $this->findAction($actionId);

        if ($action) {
            // If $actionableItemId is null then it is a bulk action
            // and it uses the current selection
            $actionableItems = $actionableItemId ? $this->getModelWhoFiredAction($actionableItemId) : $this->selected;
            $action->view = $this;
            $action->handle($actionableItems, $this);
        } else {
            throw new Exception("Unable to find the {$actionId} action");
        }
    }
    /**
     * Finds an action by its id
     */
    private function findAction(string $actionId)
    {
        $actions = collect($this->actions)->merge($this->bulkActions);

        return $actions->first(
            function ($actionToFind) use ($actionId) {
                return $actionToFind->id === $actionId;
            }
        );
    }

    /**
     * Computed properties
     */
    public function getActionsProperty()
    {
         // This `getActions()` function needs to be defined by the
         // view that is using actions
        return $this->getActions();
    }

    public function getBulkActionsProperty()
    {
        if (method_exists($this, 'bulkActions')) {
            return $this->bulkActions();
        }

        return [];
    }

    public function getHasBulkActionsProperty()
    {
        return method_exists($this, 'bulkActions') && count($this->bulkActions) > 0;
    }
}
