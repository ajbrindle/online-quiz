# Interactive Trivia Quiz

A lightweight, browser-based trivia quiz application. The app dynamically generates interactive letter boxes for answers, features a progressive clue system with point deductions, and supports multiple question packs with a secure web-based upload system.

## Features

* **Multiple Question Packs:** The app automatically detects any text file starting with `q` (e.g., `questions.txt`, `q_movies.txt`) and generates a playable menu button using the title inside the file.
* **Web Uploads:** Users can upload new question packs directly from the browser via `upload.html`.
* **Password Protection:** Uploads are secured by a static password configured in a backend PHP file.
* **Smart Input Fields:** Answer boxes automatically scale to fit the longest word, wrap cleanly onto new lines for multi-word answers, and feature seamless forward/backward keyboard focus navigation.
* **Progressive Clues:** Players can reveal up to 4 clues per question. Clues cost "bonus points" to reveal and will lock automatically if the player cannot afford them.
* **Rich Clue Formats:** Clues support standard text, embedded HTML tags (like `<b>` and `<i>`), and image URLs.
* **Image Blurring:** Image clues can be partially obscured using a custom 0-100 blur factor.
* **Dynamic Letter Reveal:** A special "Reveal letters" clue type lets players choose how many random letters they want to reveal for varying point costs. These revealed letters lock into place and are smartly skipped when the user is typing.
* **Dynamic Scoring:** Players earn 1 base point for a correct answer, plus any remaining bonus points not spent on clues or incorrect guesses.

## Getting Started

### Prerequisites

Because the application uses a PHP backend (`api.php`) to scan the directory for question packs and handle secure file uploads, it must be hosted on a PHP-enabled web server.

### Running Locally

Navigate to the project directory in your terminal and start a local PHP development server:

```bash
php -S localhost:8000
```
Then, open `http://localhost:8000` in your browser.

### Configuration

Before uploading files, you must create a `config.php` file in the root directory to set your upload password. This file should be excluded from version control (using `.gitignore`).

**config.php**
```php
<?php
define('UPLOAD_PASSWORD', 'your_secret_password');
?>
```

## File Structure

* `index.html`: The main application menu and quiz interface.
* `upload.html`: The user interface for uploading new question packs.
* `api.php`: The PHP backend script that lists available packs and processes secure uploads.
* `config.php`: (User created) Stores the secret `UPLOAD_PASSWORD`.
* `.gitignore`: Ensures `config.php` is not committed to source control.
* `q*.txt`: The data files containing your questions (e.g., `questions1.txt`). 
* `demo.txt`: (Optional) If present, a "Try Demo" button will automatically appear on the menu.

## Question Format

Questions are stored in text files. **The file name MUST start with the letter `q` and end with `.txt`.** 

The **very first line** of the file must be the title of the pack (this is what appears on the Start screen button). The rest of the file uses a custom syntax separated by `---`.

### Syntax Rules
* **Title Line:** The first line of the file (e.g., `General Knowledge Pack 1`).
* **Q Line:** `Q: [Number] | Question: [Question Text] | Answer: [ANSWER] | Points: [Bonus Points Available]`
* **C Line (Standard):** `C: [Clue Number] | Hint: [Hint Title] | Content: [Clue Text, HTML, or Image URL] | Points: [Penalty Cost] | Blur: [0-100] (Optional)`
* **C Line (Reveal Letters):** To use the letter reveal mechanic, the Hint must be exactly `Reveal letters`. The Content must be a comma-separated list formatted as `letters:cost`. The Points value at the end can be set to `0`. Example: `C: 4 | Hint: Reveal letters | Content: 2:1,4:2,6:3 | Points: 0`

### Example Block

```text
General Knowledge Mix
Q: 1 | Question: Classic 20th Century Novel | Answer: CATCH 22 | Points: 6
C: 1 | Hint: Author | Content: It was written by American author <b>Joseph Heller</b> and first published in 1961. | Points: 1
C: 2 | Hint: Setting | Content: It follows Captain John Yossarian, a bombardier stationed on the island of <i>Pianosa</i>. | Points: 1
C: 3 | Hint: Title Meaning | Content: The title originated a famous idiom describing a <b>paradoxical situation</b>. | Points: 2
C: 4 | Hint: Reveal letters | Content: 2:1,4:2,6:3 | Points: 0
---
```