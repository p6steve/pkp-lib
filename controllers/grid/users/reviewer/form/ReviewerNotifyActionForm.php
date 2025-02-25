<?php
/**
 * @file controllers/grid/users/reviewer/form/ReviewerNotifyActionForm.php
 *
 * Copyright (c) 2014-2021 Simon Fraser University
 * Copyright (c) 2003-2021 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * @class ReviewerNotifyActionForm
 * @ingroup controllers_grid_users_reviewer_form
 *
 * @brief Perform an action on a review including a reviewer notification email.
 */

namespace PKP\controllers\grid\users\reviewer\form;

use APP\core\Application;
use APP\facades\Repo;
use PKP\form\Form;
use PKP\mail\SubmissionMailTemplate;

abstract class ReviewerNotifyActionForm extends Form
{
    /** @var ReviewAssignment The review assignment to alter */
    public $_reviewAssignment;

    /** @var Submission The submission associated with the review assignment */
    public $_submission;

    /** @var ReviewRound The review round associated with the review assignment */
    public $_reviewRound;

    /**
     * Constructor
     *
     * @param ReviewAssignment $reviewAssignment
     * @param ReviewRound $reviewRound
     * @param Submission $submission
     * @param string $template
     */
    public function __construct($reviewAssignment, $reviewRound, $submission, $template)
    {
        $this->setReviewAssignment($reviewAssignment);
        $this->setReviewRound($reviewRound);
        $this->setSubmission($submission);
        parent::__construct($template);
    }

    abstract protected function getEmailKey();

    //
    // Overridden template methods
    //
    /**
     * @copydoc Form::initData
     */
    public function initData()
    {
        $request = Application::get()->getRequest();
        $submission = $this->getSubmission();
        $reviewAssignment = $this->getReviewAssignment();
        $reviewRound = $this->getReviewRound();
        $reviewerId = $reviewAssignment->getReviewerId();

        $this->setData([
            'submissionId' => $submission->getId(),
            'stageId' => $reviewRound->getStageId(),
            'reviewRoundId' => $reviewRound->getId(),
            'reviewAssignmentId' => $reviewAssignment->getId(),
            'dateConfirmed' => $reviewAssignment->getDateConfirmed(),
            'reviewerId' => $reviewerId,
        ]);

        $template = new SubmissionMailTemplate($submission, $this->getEmailKey());
        if ($template) {
            $reviewer = Repo::user()->get($reviewerId);
            $user = $request->getUser();

            $template->assignParams([
                'recipientName' => $reviewer->getFullName(),
                'senderName' => $user->getFullname(),
            ]);
            $template->replaceParams();

            $this->setData('personalMessage', $template->getBody());
        }
    }

    /**
     * @copydoc Form::readInputData()
     */
    public function readInputData()
    {
        $this->readUserVars([
            'personalMessage',
            'reviewAssignmentId',
            'reviewRoundId',
            'reviewerId',
            'skipEmail',
            'stageId',
            'submissionId',
        ]);
    }

    //
    // Getters and Setters
    //
    /**
     * Set the ReviewAssignment
     *
     * @param mixed $reviewAssignment ReviewAssignment
     */
    public function setReviewAssignment($reviewAssignment)
    {
        $this->_reviewAssignment = $reviewAssignment;
    }

    /**
     * Get the ReviewAssignment
     *
     * @return ReviewAssignment
     */
    public function getReviewAssignment()
    {
        return $this->_reviewAssignment;
    }

    /**
     * Set the ReviewRound
     *
     * @param mixed $reviewRound ReviewRound
     */
    public function setReviewRound($reviewRound)
    {
        $this->_reviewRound = $reviewRound;
    }

    /**
     * Get the ReviewRound
     *
     * @return ReviewRound
     */
    public function getReviewRound()
    {
        return $this->_reviewRound;
    }

    /**
     * Set the submission
     *
     * @param Submission $submission
     */
    public function setSubmission($submission)
    {
        $this->_submission = $submission;
    }

    /**
     * Get the submission
     *
     * @return Submission
     */
    public function getSubmission()
    {
        return $this->_submission;
    }
}
