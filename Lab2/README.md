# Student portfolio starter

Open `index.html` in a browser to view the website. No installation or build tools are needed. An internet connection is needed for Bootstrap and Google Maps.

## Files

- `index.html`: homepage, profile placeholder, skills, and about preview.
- `about.html`: background, education, skills, and interests.
- `portfolio.html`: three responsive sample project cards.
- `contact.html`: demonstration contact form and responsive Google Map.
- `signin.html`: demonstration sign-in form.
- `signup.html`: demonstration registration form.
- `terms.html`: editable sample terms.
- `privacy.html`: editable sample privacy policy.
- `cookies.html`: editable sample cookie policy.
- `css/style.css`: shared colors, spacing, images, forms, and responsive styling.
- `images/`: empty folder ready for your own images.
- `README.md`: setup and personalization notes.

## Personalize before submitting

1. Replace Your Name throughout the pages, including page titles and footer text.
2. Update Your University, graduation year, biography, skills, and interests in `about.html`. Rewrite the home introduction in your own words.
3. Replace sample projects with work you actually completed. Describe your own contribution and technologies accurately.
4. Put profile and project images in `images/`. Replace the styled placeholder divs with images, for example:

```html
<img src="images/profile.jpg" class="profile-image" alt="Portrait of Your Name">
<img src="images/project-1.jpg" class="project-image" alt="Screenshot of my project homepage">
```

Only use those paths after adding files with those names. Profile placeholders appear on Home and About; project placeholders appear on Portfolio.

5. Project buttons are intentionally disabled because no real project links were supplied. Replace each button with an anchor, using your actual URL:

```html
<a class="btn btn-primary" href="YOUR_REAL_PROJECT_URL">View Project</a>
<a class="btn btn-outline-primary" href="YOUR_REAL_REPOSITORY_URL">GitHub</a>
```

6. In `contact.html`, find the comment `Replace this iframe src with your own Google Maps embed URL.` Replace the iframe `src`, title, and the nearby map link with your chosen public location. The current example is the University of Idaho.
7. Rewrite all three sample policies to match your finished project and any services you use. Add real contact details if you intend to publish later.

## Forms and JavaScript

Forms appear on Contact, Sign In, and Sign Up. Browser validation checks required fields and email formatting. A small submit handler on each page prevents submission and shows a demo message. No form data is sent or stored, no accounts are created, and Remember Me does not persist. Password matching is not implemented. Use sample details only.

Bootstrap's bundle controls the collapsing navbar. There are no other libraries or build tools. Every page includes Bootstrap 5.3.3 CSS and JavaScript through jsDelivr.

## Reviewing your work

The navbar is repeated in each HTML file to keep the project simple. If you change its links, update all nine pages. Each main navigation page uses `active` and `aria-current="page"` on its own link. Policy pages highlight their current footer link instead.

Check the pages at mobile, tablet, and desktop widths. Try opening and closing the mobile navigation, following links, and submitting the demo forms. Local navigation works without internet, but Bootstrap styling, the navbar toggle, and the map need their external resources.

This is an unpublished starter project, not a submission document.
