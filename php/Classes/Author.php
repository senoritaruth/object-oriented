<?php

namespace rcisneros\ObjectOriented;
require_once("autoload.php");
require_once(dirname(__DIR__) . "/vendor/autoload.php");

use http\Params;
use Ramsey\Uuid\Uuid;
/**
 * Object Oriented Project
 *
 * This is a project to practice Object Oriented programming. It is based on the author DDL posted in the web-kobayashi-maru slack channel.
 *
 * @author Ruth Dove <senoritaruth@gmail.com>
 * Version 1.0.0
 **/
class author {
	use ValidateUuid;
	/**
	 * id for this author; this is the primary key
	 * @var Uuid $authorId
	 **/
	private $authorId;
	/**
	 * picture for author
	 * @var string $authorAvatarUrl
	 **/
	private $authorAvatarUrl;
	/**
	 * token handed out to verify that the profile is valid and not malicious.
	 * @var string $authorActivationToken
	 **/
	private $authorActivationToken;
	/**
	 * email for this author; this is a unique index
	 * @var string $authorEmail
	 **/
	private $authorEmail;
	/**
	 * hash for this author password
	 * @var string $authorHash
	 **/
	private $authorHash;
	/**
	 * user name for this author
	 * @var string $authorUsername
	 **/
	private $authorUserName;

	/**
	 *constructor for author
	 *
	 * @param string|Uuid $authorId of this profile or null if new profile
	 * @param string $authorAvatarUrl
	 * @param string $authorActivationToken
	 * @param string $authorEmail
	 * @param string $authorHash
	 * @param string $authorUserName
	 *
	 **/
	public function __construct(string $authorId, string $authorAvatarUrl, ?string $authorActivationToken, string $authorEmail, string $authorHash, string $authorUserName) {
		try {
			$this->setauthorId($authorId);
			$this->setauthorAvatarUrl($authorAvatarUrl);
			$this->setauthorActivationToken($authorActivationToken);
			$this->setauthorEmail($authorEmail);
			$this->setauthorHash($authorHash);
			$this->setauthorUserName($authorUserName);
		} catch(\InvalidArgumentException | \RangeException | \TypeError | \Exception $exception) {
			//determine what exception type was thrown
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for author id
	 * @return Uuid value of author id (or null if new)
	 **/
	public function getauthorId(): Uuid {
		return ($this->authorId);
	}

	/**
	 * mutator method for author id
	 *
	 * @param Uuid| string $newauthorId value of new author id
	 * @throws \RangeException if $newauthorId is not positive
	 * @throws \TypeError if the profile Id is not
	 **/
	public function setauthorId($newauthorId): void {
		try {
			$uuid = self::validateUuid($newauthorId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		//convert and store the author id
		$this->authorId = $uuid;
	}

	/** accessor method for author avatar url
	 *
	 * @return string value of the author avatar url
	 **/
	public function getauthorAvatarUrl(): string {
		return $this->authorAvatarUrl;
	}

	/**
	 * mutator method for author avatar url
	 *
	 * @param string $authorAvatarUrl new value of profile avatar URL
	 * @throws \InvalidArgumentException if the url is not a string or is insecure
	 * @throws \RangeException if the url is > 255 characters
	 * @throws \TypeError if the url is not a string
	 *
	 **/
	public function setauthorAvatarUrl(string $newauthorAvatarUrl): void {

		$newauthorAvatarUrl = trim($newauthorAvatarUrl);
		$newauthorAvatarUrl = filter_var($newauthorAvatarUrl, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		// verify the URL will fit in the db
		if(strlen($newauthorAvatarUrl) > 255) {
			throw(new \RangeException("image cloudinary content too large"));
		}
		//store the image cloudinary content
		$this->authorAvatarUrl = $newauthorAvatarUrl;
	}

	/**
	 * accessor method for author activation token
	 *
	 * @return string value of the activation token
	 **/
	public function getAuthorActivationToken(): ?string {
		return ($this->authorActivationToken);
	}

	/**
	 *mutator method for author activation token
	 *
	 * @param string $newauthorActivationToken
	 * @throws \InvalidArgumentException if the token is not a string or is insecure
	 * @throws \RangeException if the token is not exactly 32 characters
	 * @throws \TypeError if the activation token is not a string
	 **/
	public function setauthorActivationToken(?string $newauthorActivationToken): void {
		if($newauthorActivationToken === null) {
			$this->authorActivationToken = null;
			return;
		}
		$newauthorActivationToken = strtolower(trim($newauthorActivationToken));
		if(ctype_xdigit($newauthorActivationToken) === false) {
			throw(new\RangeException("user activation is not valid"));
		}
		//make sure author activation token is only 32 characters
		if(strlen($newauthorActivationToken) !== 32) {
			throw(new\RangeException("user activation token has to be 32 characters"));
		}
		$this->authorActivationToken = $newauthorActivationToken;
	}

	/**
	 *accessor method for author email
	 *
	 * @return string value of email
	 **/
	public function getauthorEmail(): string {
		return $this->authorEmail;
	}

	/**
	 * mutator method for author email
	 *
	 * @param string $newauthorEmail new value of author email
	 * @throws \InvalidArgumentException if $newauthorEmail is not a valid email or is   * insecure
	 * @throws \RangeException if $newauthorEmail is > 128 chars
	 * @throws \TypeError if $newauthorEmail is not a string
	 **/
	public function setauthorEmail(string $newauthorEmail): void {
		// verify the email is secure
		$newauthorEmail = trim($newauthorEmail);
		$newauthorEmail = filter_var($newauthorEmail, FILTER_VALIDATE_EMAIL);
		if(empty($newauthorEmail) === true) {
			throw(new \RangeException("profile email is empty or insecure"));
		}
		//store the email
		$this->authorEmail = $newauthorEmail;
	}

	/**
	 * accessor method for author hash
	 *
	 * @return string value of hash
	 **/
	public function getauthorHash(): string {
		return $this->authorHash;
	}

	/**mutator method for author hash
	 *
	 * @param string $newauthorHash
	 * @throws \InvalidArgumentException if the hash is not secure
	 * @throws \RangeException if the hash is not 97 chars
	 * @throws \TypeError if author hash is not a string
	 **/
	public function setauthorHash(string $newauthorHash): void {
		//enforce that the hash is properly formatted
		$newauthorHash = trim($newauthorHash);
		if(empty($newauthorHash) === true) {
			throw(new \InvalidArgumentException("profile hash empty or insecure"));
		}
		//enforce that the hash is really an Argon hash
		$authorHashInfo = password_get_info($newauthorHash);
		if($authorHashInfo["algoName"] !== "argon2i") {
			throw(new \RangeException("author hash is not a valid hash"));
		}
		//enforce that the hash is exactly 97 chars
		if(strlen($newauthorHash) !== 97) {
			throw(new \RangeException("author hash must be 97 characters"));
		}
		//store the hash
		$this->authorHash = $newauthorHash;
	}

	/**accessor method for author User Name
	 *
	 * @return string value of authorUserName
	 **/
	public function getauthorUserName(): string {
		return $this->authorUserName;
	}

	/** mutator method for author User Name
	 *
	 * @param string $newauthorUserName new value of author User Name
	 * @throws \InvalidArgumentException if $newauthorUserName is not secure
	 * @throws \RangeException if $newauthorUserName is > 32 characters
	 * @throws \TypeError if $newauthorUserName is not a string
	 **/
	public function setauthorUserName(string $newauthorUserName): void {
		// verify the user name is secure
		$newauthorUserName = trim($newauthorUserName);
		$newauthorUserName = filter_var($newauthorUserName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newauthorUserName) === true) {
			throw(new \InvalidArgumentException("Author User Name is empty or insecure"));
		}
		// verify the author user name will fit in the database
		if(strlen($newauthorUserName) > 32) {
			throw(new \RangeException("author user name is too long"));
		}
		// store the author user name
		$this->authorUserName = $newauthorUserName;
	}


	/**
	 * Inserts this author into MySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when MySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 *
	 **/
	public function insert(\PDO $pdo): void {

		//create query template
		$query = "INSERT INTO author(authorId, authorAvatarUrl, authorActivationToken, authorEmail, authorHash, authorUserName) VALUES(:authorId, :authorAvatarUrl, :authorActivationToken, :authorEmail, :authorHash, :authorUserName)";
		$statement = $pdo->prepare($query);

		//bind the member variables to the placeholders in the template
		$parameters = ["authorId" => $this->authorId->getBytes(), "authorAvatarUrl" => $this->authorAvatarUrl, "authorActivationToken" => $this->authorActivationToken, "authorEmail" => $this->authorEmail, "authorHash" => $this->authorHash, "authorUserName" => $this->authorUserName];

		$statement->execute($parameters);
	}

	/**
	 * Updates author info in MySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when MySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/

	public function update(\PDO $pdo): void {
		$query = "UPDATE author SET authorId = :authorId, authorAvatarUrl = :authorAvatarUrl, authorActivationToken = :authorActivationToken, authorEmail = :authorEmail, authorHash = :authorHash, authorUserName = :authorUserName WHERE authorId = :authorId";
		$statement = $pdo->prepare($query);

		$parameters = ["authorId" => $this->authorId->GetBytes(), "authorAvatarUrl" => $this->authorAvatarUrl, "authorActivationToken" => $this->authorActivationToken, "authorEmail" => $this->authorEmail, "authorHash" => $this->authorHash, "authorUserName" => $this->authorUserName];
		$statement->execute($parameters);
	}

	/**
	 *deletes from author
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when MySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 *
	 **/

	public function delete(\PDO $pdo): void {

		$query = "DELETE FROM author WHERE authorId = :authorId";
		$statement = $pdo->prepare($query);

		$parameters = ["authorId" => $this->authorId->getBytes()];
		$statement->execute($parameters);
	}

	/**gets the author info by the authorId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $authorId author id to search for
	 * @return author|null author found or null if not found
	 * @throws \PDOException when MySQL related errors occur
	 * @throws \TypeError when variable is not the correct data type
	 *
	 **/

	public static function getauthorbyauthorId(\PDO $pdo, $authorId): ?author {
		// sanitize the author before searching
		try {
			$authorId = self::validateUuid($authorId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT authorId, authorAvatarUrl, authorActivationToken, authorEmail, authorHash, authorUserName FROM author WHERE authorID = :authorId";
		$statement = $pdo->prepare($query);

		//bind the tweet id to the placeholder in the template
		$parameters = ["authorId" => $authorId->getBytes()];
		$statement->execute($parameters);

		//grab the author from MySQL
		try {
			$author = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$author = new author($row[$authorId]);
			}
		} catch(\Exception $exception) {
			//if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $except));
		}
		return ($tweet);
	}

	/**
	 * returns all author info in an array
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \splFixedArray SplFixedArray of Tweets found or null if not found
	 * @throws \PDOException when MySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/

	public static function getAllauthor(\PDO $pdo): \SPLFixedArray {
		//create query template
		$query = "SELECT authorId, authorAvatarUrl, authorActivationToken, authorEmail, authorHash, authorUserName FROM author";
		$statement = $pdo->prepare($query);
		$statement->execute();

		//build an array of author info
		$authors = new \SPLFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$author = new Author($row["authorId"], $row["authorAvatarUrl"], $row["authorActivationToken"], $row["authorEmail"], $row["authorHash"], $row["authorUserName"]);
				$authors[$authors->key()] = $author;
				$tweets->next();
			} catch(\Exception $exception) {
				//if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($authors);
	}

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize(): array {
		$fields = get_object_vars($this);

		$fields["authorId"] = $this->authorId->toString();
	}
}
