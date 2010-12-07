cd /var/jackrabbit
instance=`wget -O - -q http://169.254.169.254/latest/meta-data/instance-id`
echo $instance
java -D"org.apache.jackrabbit.core.cluster.node_id=$instance" -jar /var/jackrabbit/trunk/jackrabbit-standalone/target/jackrabbit-standalone-2.2-SNAPSHOT.jar 
