cd webDiplomacy/variants

for dir in *;
do
	if [ -d "$dir" ] &&  [ ! -d $dir/cache ] &&  [ "$dir" != "author_utilities" ] ; then
		echo "Deploying cache folder in $dir"
		cp -r ./Classic/cache $dir/cache
	fi
done
