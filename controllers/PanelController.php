<?php
class PanelController
{
    private PanelModel $model;

    public function __construct(PanelModel $model)
    {
        $this->model = $model;
    }

    public function getDashboardData(): array
    {
        return [
            'stats' => $this->model->getStats(),
            'activity' => $this->model->getActivity(),
            'occupancy' => $this->model->getOccupancy(),
        ];
    }
}
