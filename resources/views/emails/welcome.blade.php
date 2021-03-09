@component('mail::message')

# Welcome to 24Hours!

Hello {{ $user->first_name }}!

In this email, I would like to tell you a bit more about 24Hours. How it works and when you should use it.

**I recommend saving this email as it explains the core features of 24Hours.**

## Boards, notes, and links

Think of a board as a space to organize a project. For example, if you're creating a new website there is a lot to be done, and you can create a board to save everything.

Notes are... notes! You can add as many notes as you would like. You can use them to write whole essays or to quickly clean your head. Notes are auto-saved, so all your edits will be saved immediately.

If you found something on the internet that you want to save for later, you can save them as a link. 24Hours will automatically get the title and an image so you can quickly and easily see which link is what page.

## Search

Using 24Hours powerful search feature you can find everything that you've lost! Head over to the search page and go searching!

## Collaboration

Working together is very easy using 24Hours' collaboration feature. You can invite anyone, also people who don't have an account yet.

In a board there are three roles with their own permissions:

**Owner**: this is the creator of the board. Only the owner can edit or delete the board and can invite (and remove) members and viewers.

**Member**: a member can create, edit and delete notes and add and remove links. The member can not edit the board itself or invite other members and viewers.

**Viewer**: a viewer can only view notes and links. They cannot edit anything.

## Support

If you have any questions, feature requests, or anything else, please contact me at [https://www.jeroenvanrensen.nl/contact](https://www.jeroenvanrensen.nl/contact).

Thanks for using 24Hours,<br />
Jeroen van Rensen<br />
*Creator of 24Hours*

@endcomponent
