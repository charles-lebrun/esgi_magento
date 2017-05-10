FROM webdevops/php-apache:debian-8

MAINTAINER Charles Lebrun <c.lebrun@rhinos.fr>

# ajoute les paquets manquants
RUN apt-get update \
  && apt-get install -y \
  php5-tidy
