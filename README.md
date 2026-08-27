# Interactive Trivia Quiz

A lightweight, browser-based trivia quiz application built with vanilla HTML, CSS, and JavaScript. The app dynamically generates interactive letter boxes for answers, features a progressive clue system with point deductions, and loads questions from a local text file.

## Features

* **Smart Input Fields:** Answer boxes automatically scale to fit the longest word, wrap cleanly onto new lines for multi-word answers, and feature seamless forward/backward keyboard focus navigation.
* **Progressive Clues:** Players can reveal up to 4 clues per question. Clues cost "bonus points" to reveal and will lock automatically if the player cannot afford them.
* **Rich Clue Formats:** Clues support standard text, embedded HTML tags (like `<b>` and `<i>`), and image URLs.
* **Image Blurring:** Image clues can be partially obscured using a custom 0-100 blur factor.
* **Dynamic Scoring:** Players earn 1 base point for a correct answer, plus any remaining bonus points not spent on clues or incorrect guesses.
* **Zero Dependencies:** Pure HTML, CSS, and JS in a single file.

## Getting Started

### Prerequisites

Because the application uses the Javascript `fetch()` API to load the question files dynamically, it cannot be run directly via the `file://` protocol due to browser CORS (Cross-Origin Resource Sharing) security restrictions. 

You must serve the directory using a local web server. 

### Running Locally

Navigate to the project directory in your terminal and start a local server using your preferred environment:

**Python:**
```bash
python3 -m http.server 8000
```

**PHP:**
```bash
php -S localhost:8000
```

**Node.js / npm:**
```bash
npx serve
```

Alternatively, if you are using VS Code, you can use the **Live Server** extension to launch the app. Once the server is running, open `http://localhost:8000` in your browser.

## File Structure

* `index.html`: The main application containing all markup, styles, and logic.
* `questions.txt`: The primary data file containing the questions, answers, and clues.
* `demo.txt`: (Optional) If this file is present in the directory, a "Try Demo" button will automatically appear on the start screen.

## Question Format

Questions are stored in `questions.txt` using a custom, easy-to-read syntax separated by `---`. 

### Syntax Rules
* **Q Line:** `Q: [Number] | Question: [Question Text] | Answer: [ANSWER] | Points: [Bonus Points Available]`
* **C Line:** `C: [Clue Number] | Hint: [Hint Title] | Content: [Clue Text, HTML, or Image URL] | Points: [Penalty Cost] | Blur: [0-100] (Optional)`

### Example Block

```text
Q: 1 | Question: Classic 20th Century Novel | Answer: CATCH 22 | Points: 6
C: 1 | Hint: Author | Content: It was written by American author <b>Joseph Heller</b> and first published in 1961. | Points: 1
C: 2 | Hint: Setting | Content: It follows Captain John Yossarian, a bombardier stationed on the island of <i>Pianosa</i>. | Points: 1
C: 3 | Hint: Title Meaning | Content: The title originated a famous idiom describing a <b>paradoxical situation</b>. | Points: 2
C: 4 | Hint: Screen Adaptations | Content: [https://example.com/movie-poster.jpg](https://example.com/movie-poster.jpg) | Points: 1 | Blur: 50
---
```