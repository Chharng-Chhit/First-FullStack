# Safe HTML & JavaScript Injection Awareness Lab

This lesson is for defensive classroom training only.

## Goal
Students learn why unsafe rendering is dangerous and how to prevent HTML/JavaScript injection bugs.

## What students learn

- `innerHTML` treats input as HTML.
- `textContent` treats input as normal text.
- Inline event attributes are risky.
- `eval()` should not be used with user input.
- URLs should be validated before use.

## Allowed classroom demo inputs

Use harmless visual examples only:

```html
<b>Hello student</b>
<h3>Large title</h3>
<span style="color: blue;">Blue text</span>
```

Do not test on real websites. Do not include real attack payloads. Only use local demo files you own.

## Main prevention rules

1. Never trust user input.
2. Prefer `textContent` for user text.
3. Avoid `innerHTML` with user input.
4. Avoid inline event attributes.
5. Never use `eval()` with user input.
6. Validate links and file paths.
7. Escape output on backend templates.
