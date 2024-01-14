<?php

namespace Firesphere\Notebook\Controllers;

use Firesphere\Notebook\Models\Note;
use Firesphere\Notebook\Pages\NotebookPage;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Security\Security;
use SilverStripe\View\Requirements;

/**
 * Class \Firesphere\Notebook\Controllers\NotebookPageController
 *
 * @property NotebookPage $dataRecord
 * @method NotebookPage data()
 * @mixin NotebookPage
 */
class NotebookPageController extends \PageController
{
    protected $Note;

    private static $allowed_actions = [
        'view',
        'delete',
        'NotebookForm'
    ];

    /**
     * @return mixed
     */
    public function getNote()
    {
        return $this->Note;
    }

    protected function init()
    {
        if (!Security::getCurrentUser()) {
            $this->httpError(403);

            return;
        }
        parent::init();
    }

    public function view(HTTPRequest $request)
    {
        $this->Note = Note::get()->filter([
            'ID'       => (int)$request->param('ID'),
            'MemberID' => Security::getCurrentUser()->ID
        ]);

        return $this;
    }

    public function delete(HTTPRequest $request)
    {
        if (!Security::getCurrentUser()) {
            $this->httpError(403);

            return;
        }
        /** @var Note $note */
        $note = Security::getCurrentUser()
            ->NotebookNotes()
            ->filter(['ID' => $request->param('ID')])
            ->first();

        if ($note) {
            $note->delete();
            $note->destroy();
        }

        $this->redirectBack();
    }
}
