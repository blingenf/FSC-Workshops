#!/bin/bash

if [ $# -ne 1 ]; then
  echo "usage: flagdump [<flag>|-c]"
else
  echo ""
  echo "Connecting to the flag server. Use your FSC password."
  echo "To just connect to the flag server, use 'flagdump -c'."
  echo ""

  if [ "$1" = "-c" ]; then
    ssh <flag server ip>
  else
    ssh <flag server ip> "flagdump $1"
  fi
fi
