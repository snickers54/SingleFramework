# SingleFramework

I developed this micro framework (PHP), initially for my dblink project, which is an ogame-like web browerser based game.There is no official documentation, I will maybe take time to do it but this is a relic of the past.
I developed the first version around December 2010, and that's part of why this is an old approach of web development where backend is serving the frontend pages.
There is not that much to say, I mainly did this to learn how to make a router, implement my own MVC, understand concepts behind famous frameworks.

I wanted a minimalist framework, able to be upgraded with library, this is not fully automatic but at least I tried. I've produce around 3 or 4 projects with this framework.

Basically, the router (called rooter yeah I feel a bit ashamed for my terrible english back then) is pretty simple, and parsing with this pattern in mind :

- each URL has to contain at least a controller and an action, by default and if missings, the controller and the action will be `index`
- If the router is finding more than 2 elements slash separated in the uri, he will considered right members as /controller/action and left members as modules.
- Modules are basically a subfolder in controller path.

So if you understood right : /`module1`/`module2`/`controller`/`action`?`query_string`

The html template engine was Twig, at that time Symfony 2 wasn't release I think ?!

Ex :
- /game/start -> gameController / startAction
- /game/ -> gameController / indexAction
- / -> indexController / indexAction
- /launchpage/subscribe/form -> launchpage subfolder / subscribeController / formAction

Have fun reading this awful code :)
   
