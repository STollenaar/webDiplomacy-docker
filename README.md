# webDiplomacy-docker
webdiplomacy integrated in docker, original from https://github.com/TimothyJones/webDiplomacy-dev-docker


# Instalation

1. [Download and install Docker](https://docs.docker.com/install/). The Community Edition should work just fine. 
2. Once Docker is installed and ready to use run `docker create -v /var/lib/mysql --name webdip mysql` .
3. Navigate to where you want to keep this repo and clone it.
4. Configure the config.php in the root folder of this repo as seen in Configuration.
5. Simply run the start-server.sh and it should do everything neccessary to run webdiplomacy.
(Optional)
6. To run the docker container in the foreground open start-server.sh and navigate to where it says `docker run` and remove the `-d` flag.
7. To run it in the background again add the `-d` flag again

# Configuration

1. There is a config.php file in the root folder of this repo. Simply change that and once you restart the docker container these changes will be made to the container.
2. Importantly change the gamemaster secrets in the config.php, and change it accordingly in the gameCron file!!
3. The start-server.sh tries to keep the webdiplomacy folder up to date with the [official webdiplomacy repo](https://github.com/kestasjk/webDiplomacy). To disable this add a `#` infront of the git command in the start-server.sh
4. If you want to use a forked branch of the [official webdiplomacy repo](https://github.com/kestasjk/webDiplomacy) navigate to the webdiplomacy folder and run `git remote set-url forkedR <desired url>` . Then in the start-server.sh in the git command change origin to forkedR. Once that's done simply restart the docker container and the changed of that forkedbranch should be visible.

# Future running

1. Simply run the start-server.sh again or try with `docker webdiplomacydevLinux start`

