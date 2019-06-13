# Refactor it!

### Simple startup

When no project files are present yet:

- `pullit install`; first time installation

- `pullit init`; first time project init (when no Pullit files are in the project)

### Configuration

Edit the local core file in `~/.pullit.json`

```bash
{
    "towerUsername": "wiardvanrij",
    "mysqlUser": "root",
    "mysqlPassword": "root",
    "mysqlHost": "localhost",
    "mysqlPort": 3306
}
```

- towerUsename: The username you use to connect to the commandcloud
- mysqlUser: Localhost mysql username
- mysqlPassword: Localhost mysql password
- mysqlHost: Localhost mysql host
- mysqlPort: Localhost mysql port
 
 
 ### Project configuration
 
 You will be provided with a 

- ```private/pullit/project.json``` Project base configuration (Should be in GIT)
- ```private/pullit/local.json```  Local configuration overrides for this project (Place this in your .gitignore!)

Your `.gitignore` file should contain the following:
```git
/private/pullit/*
!/private/pullit/project.json
```

**project.json:**

```bash
{
    "cms": "wp",
    "remoteHost": "vps0018",
    "remoteUsername": "sctest",
    "remotePath": "\/home\/sctest\/",
    "dumpType": "backup",
    "externalMysqlUser": "sctest",
    "externalMysqlHost": "",
    "paths": ["www/index.php", "www/wp/readme.html"],
    "excludedPaths": [],
    "backendUsername": "",
    "backendPassword": "",
    "localDomains": [
        ["dev.domain.nl", 1]
    ]
    
}

```

- cms: wp, typo3, mage2 (for t.b.a. features)
- remoteHost: vps number
- remoteUsername: the username
- remotePath: The path of the user (mostly /home/{username})
- dumpType: backup, live
- externalMysqlUser: mysql user on the remote host
- externalMysqlHost: external mysql host, you can keep this one empty if no external server used
- paths: Array of the folders / files you want to sync. Start from the remote Path
- excludedPaths: t.b.a.
- backendUsername: add your local backend username, default is redkiwi (Currently TYPO3 only)
- backendPassword: add your local backend password, default is redkiwi (Currently TYPO3 only)
- localDomains: Array of all the local domains you will need for the project, key = domain, value = page id (Currently TYPO3 only)

# Available commands:
- config   Displays or (re)sets the Pullit config
- diffs    Syncs the files

#Development

### How to test this tool?
1: Add the project path to your `~/.composer/composer.json` as repository, for example:

```json
  "repositories": [
    {
      "type": "path",
      "url": "/Users/Username/Projects/refactor-it"
    }
  ]
```

2: You can now use the command `pullit`

