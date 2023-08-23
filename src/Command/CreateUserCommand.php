<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;
use Viewpoint\AdminBundle\Entity\Role;
use Viewpoint\AdminBundle\Entity\User;
use Viewpoint\AdminBundle\Service\Emailing;

// the name of the command is what users type after "php bin/console"
#[AsCommand(name: "app:create-user", description: "Creates a new user.", hidden: false)]
class CreateUserCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $userPasswordHasher,
        private ValidatorInterface $validator,
        private Emailing $emailing
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setHelp("This command allows you to create a user on production");
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln(["User Creator", "============", ""]);

        /** @var QuestionHelper */
        $helper = $this->getHelper("question");

        $choiseUserType = new ChoiceQuestion(
            "Would you like to create a user with ROLE_ADMIN or ROLE_USER",
            // choices can also be PHP objects that implement __toString() method
            ["ROLE_ADMIN", "ROLE_USER"],
            0
        );
        $choiseUserType->setErrorMessage("Invalid Role.");

        $choisenUserType = $helper->ask($input, $output, $choiseUserType);

        $role = $this->entityManager
            ->getRepository(Role::class)
            ->findOneBy(["name" => $choisenUserType]);

        if (!$role) {
            throw new \RuntimeException(
                "We were not able to fetch any role " . $choisenUserType . " in your database"
            );
        }

        $usernameQuestion = (new Question("Enter the username: "))
            ->setTrimmable(true)
            ->setValidator(function (string $answer): string {
                if ($this->isUsernameTaken($answer)) {
                    throw new \RuntimeException("username already taken");
                }

                return $answer;
            });
        $username = $helper->ask($input, $output, $usernameQuestion);

        $emailQuestion = (new Question("Enter the email: "))
            ->setTrimmable(true)
            ->setValidator(function (string $answer): string {
                if ($this->isEmailTaken($answer)) {
                    throw new \RuntimeException("Email already taken");
                }

                return $answer;
            });
        $email = $helper->ask($input, $output, $emailQuestion);

        $passwordQuestion = (new Question("Enter the password (hidden): "))
            ->setHidden(true)
            ->setHiddenFallback(false)
            ->setValidator(function (string $answer): string {
                $error = $this->isPasswordInvalid($answer);
                if ($error) {
                    echo $answer;
                    throw new \RuntimeException($error);
                }

                return $answer;
            });
        $password = $helper->ask($input, $output, $passwordQuestion);

        $user = (new User())
            ->setEmail($email)
            ->setUsername($username)
            ->setRole($role);

        $user->setPassword($this->userPasswordHasher->hashPassword($user, $password));

        $violations = $this->validator->validate($user);

        if (count($violations) > 0) {
            foreach ($violations as $violation) {
                $output->writeln("<error>{$violation->getMessage()}</error>");
            }
            return Command::FAILURE;
        }

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $output->writeln(["User created", "============", ""]);

        $verificationChoiceQuestion = new ChoiceQuestion(
            "How would you like to verify the user?",
            ["Send Email", "Automatically"],
            0
        );
        $verificationChoice = $helper->ask($input, $output, $verificationChoiceQuestion);

        if ($verificationChoice === "Automatically") {
            $user->setIsVerified(true);
            $this->entityManager->flush();
        } elseif ($verificationChoice === "Send Email") {
            $this->emailing->sendEmailConfirmationHelper($user);
        } else {
            $output->writeln("<error>Invalid verification choice.</error>");
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }

    private function isUsernameTaken(string $username): bool
    {
        $result = $this->entityManager
            ->getRepository(User::class)
            ->findOneBy(["username" => $username]);

        return $result ? true : false;
    }

    private function isEmailTaken(string $email): bool
    {
        $result = $this->entityManager
            ->getRepository(User::class)
            ->findOneBy(["email" => $email, "isDeleted" => false]);

        return $result ? true : false;
    }

    private function isPasswordInvalid(string $password): ?string
    {
        $pattern = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$ %^&*-]).{8,}$/";

        if (!preg_match($pattern, $password)) {
            return "The password must contain at least 8 characters, one uppercase letter, one lowercase letter, one digit, and one special character";
        }

        return null;
    }
}
