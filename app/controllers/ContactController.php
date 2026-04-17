<?php

declare(strict_types=1);

class ContactController extends Controller
{
    public function index(): void
    {
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
            $name    = trim((string) ($_POST['name']    ?? ''));
            $email   = trim((string) ($_POST['email']   ?? ''));
            $subject = trim((string) ($_POST['subject'] ?? ''));
            $type    = trim((string) ($_POST['type']    ?? 'General'));
            $message = trim((string) ($_POST['message'] ?? ''));

            $errors = Validator::required($_POST, ['name', 'email', 'subject', 'message']);
            if (!Validator::email($email)) {
                $errors['email'] = 'Please provide a valid email.';
            }

            if ($errors !== []) {
                Session::flash('error', implode(' ', array_values($errors)));
                $this->redirect('/contact/index');
            }

            $userId = Auth::check() ? (int) Auth::user()['userId'] : null;
            $storedMessage = $userId !== null ? $message : ('From: ' . $name . ' <' . $email . '> - ' . $message);

            $contactModel = new Contact();
            $contactModel->create([
                'userId'     => $userId,
                'subject'    => $subject,
                'message'    => $storedMessage,
                'type'       => $type,
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            Session::flash('success', 'Message sent. We will be in touch shortly.');
            $this->redirect('/contact/index');
        }

        $contactModel = new Contact();
        $userInbox = [];
        $userReplies = [];
        if (Auth::check()) {
            $userInbox = $contactModel->inboxForUser((int) Auth::user()['userId']);
            $messageIds = array_map(static fn(array $row): int => (int) $row['messageId'], $userInbox);
            $userReplies = $contactModel->repliesByMessageIds($messageIds);
        }

        $this->view('contact/index', [
            'title'       => 'Contact',
            'userInbox'   => $userInbox,
            'userReplies' => $userReplies,
        ]);
    }
}
