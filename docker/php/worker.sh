if [ -f ~/.stopped ]; then (rm  ~/.stopped) fi

until [ -f ~/.stopped ];
  do bin/console messenger:consume async --limit=${MESSAGES_LIMIT} --memory-limit=${MEMORY_LIMIT} --time-limit=${TIME_LIMIT} -vv;
done