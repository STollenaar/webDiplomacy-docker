#!/bin/bash
# Simple bash logging functions
# Timothy Jones, 2017
# https://github.com/TimothyJones/timbash

# Colours
blue='\033[1;34m'
red='\033[0;31m'
green='\033[0;32m'
yellow='\033[93m'
end_colour='\033[0m'

TB_WARNINGS=()

if [ -z ${TB_PRINT_SCRIPT_NAME+x} ] ; then 
  TB_SCRIPTNAME=""
else 
  TB_SCRIPTNAME="$(basename "$0"): "
fi

function log() {
    echo -e "${blue}[  ] ${TB_SCRIPTNAME}$* ${end_colour}"
}

function info() {
    echo -e "${blue}     $* ${end_colour}"
}

function error() {
    echo -e "${red}[❌ ] ${TB_SCRIPTNAME}$* ${end_colour}"
}

function warn() {
    local WARN="${yellow}[🔔 ] ${TB_SCRIPTNAME}$* ${end_colour}"
    echo -e $WARN
    TB_WARNINGS+=("$WARN")
}

function warn_info() {
    local WARN="${yellow}     $* ${end_colour}"
    echo -e $WARN
    TB_WARNINGS+=("$WARN")
}

function warnings() {
   if [ ${#TB_WARNINGS[@]} -ne 0 ]; then
     info "If you are experiencing problems, the following warnings were reported earlier:"
     for ((i = 0; i < ${#TB_WARNINGS[@]}; i++)); do 
       echo -e "${TB_WARNINGS[$i]}"
     done
   fi
}

function success() {
    echo -e "${green} ✅  ${TB_SCRIPTNAME}$* ${end_colour}"
}

function success_banner() {
    echo -e "${green}`banner_border "$*"`${end_colour}"
    echo -e "${green}`banner_mid    "$*"`${end_colour}"
    echo -e "${green}`banner_border "$*"`${end_colour}"
}

function fail_banner() {
    echo -e "${red}`banner_border "$*"`${end_colour}"
    echo -e "${red}`banner_mid    "$*"`${end_colour}"
    echo -e "${red}`banner_border "$*"`${end_colour}"
}

function banner_border() {
    echo "`banner_mid "$*" | sed 's/./*/g'`"
}

# banner based on https://unix.stackexchange.com/a/250094
function banner_mid() {
    echo "* $* *"
}

function banner() {
    banner_border "$*"
    banner_mid "$*"
    banner_border "$*"
}
