gunzip -cd ~/Copy/e2014/e2014.gz > e2014.dump
psql -h localhost -U e2014 -W e2014 < e2014.dump
rm e2014.dump
