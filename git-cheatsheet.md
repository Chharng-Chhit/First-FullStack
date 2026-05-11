# Git Tips for Students

## First Setup

```bash
git config --global user.name "Your Name"
git config --global user.email "your@email.com"
```

## Start Git in Project

```bash
git init
git add .
git commit -m "Initial full stack task manager project"
```

## Common Commands

```bash
git status
git add .
git commit -m "Add task CRUD feature"
git log --oneline
git checkout -b feature/task-ui
git checkout main
git merge feature/task-ui
```

## Good Commit Message Examples

```txt
Add Laravel task API
Create Vue task list UI
Connect Vue frontend to Laravel API
Add task delete feature
Fix validation error handling
```

## Important Tip

Do not commit these folders/files:

```txt
node_modules/
vendor/
.env
```

Use `.env.example` instead.
