<?php

namespace RestApi\View;

use Cake\Core\Configure;
use Cake\Core\Exception\Exception;
use Cake\View\View;

/**
 * Api View
 *
 * Default view class for rendering API response
 */
class ApiView extends View
{
    public $hasRendered = false;
    /**
     * Layout
     *
     * @var string
     */
    protected $_responseLayout = 'response';

    /**
     * Initialization hook method.
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        if ('xml' === Configure::read('ApiRequest.responseType')) {
            $this->response->withType('xml');
            $this->_responseLayout = 'xml_response';
        } else {
            $this->response->withType('json');
        }
    }

    /**
     * Renders api response
     *
     * @param string|null $view Name of view file to use
     * @param string|null $layout Layout to use.
     * @return string|null Rendered content or null if content already rendered and returned earlier.
     * @throws Exception If there is an error in the view.
     */
    public function render(?string $template = null, $layout = null): string
    {
        if ($this->hasRendered) {
            return null;
        }

        $this->layout = "RestApi.{$this->_responseLayout}";

        $this->Blocks->set('content', $this->renderLayout('', $this->layout));

        $this->hasRendered = true;

        return $this->Blocks->get('content');
    }
}
