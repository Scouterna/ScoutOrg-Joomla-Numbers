membercount_source := $(shell find src/membercount -type f)
waitingcount_source := $(shell find src/waitingcount -type f)
package_source := $(shell find src/package -type f)

membercount_name := mod_scoutmembercount.zip
waitingcount_name := mod_scoutwaitingcount.zip
package_name := numbers.zip

membercount_tmp := build/tmp/membercount
waitingcount_tmp := build/tmp/waitingcount
package_tmp := build/tmp/package

membercount_target := build/tmp/$(membercount_name)
waitingcount_target := build/tmp/$(waitingcount_name)
package_target := build/$(package_name)

current_date := $(shell date +'%Y-%m-%d')

replace_text = sed -i 's/\[\[$(1)\]\]/$(2)/g' $(3)

.PHONY: all clean

all: $(package_target)

clean:
	@rm -rf build

$(package_target): $(membercount_target) $(waitingcount_target) $(package_source)
	@echo Creating package
	@rm -rf $(package_tmp)
	@mkdir -p $(package_tmp)
	@mkdir $(package_tmp)/packages
	@cp $(membercount_target) $(package_tmp)/packages
	@cp $(waitingcount_target) $(package_tmp)/packages
	@cp -r src/package/* $(package_tmp)
	@$(call replace_text,current_date,$(current_date),$(package_tmp)/pkg_scoutnumbers.xml)
	@$(call replace_text,membercount_filename,$(membercount_name),$(package_tmp)/pkg_scoutnumbers.xml)
	@$(call replace_text,waitingcount_filename,$(waitingcount_name),$(package_tmp)/pkg_scoutnumbers.xml)
	@cd $(package_tmp) && \
		zip -FSr ../../$(package_name) ./

$(waitingcount_target): $(waitingcount_source)
	@echo Creating waitingcount
	@rm -rf $(waitingcount_tmp)
	@mkdir -p $(waitingcount_tmp)
	@cp -r src/waitingcount/* $(waitingcount_tmp)
	@$(call replace_text,current_date,$(current_date),$(waitingcount_tmp)/mod_scoutwaitingcount.xml)
	@cd $(waitingcount_tmp) && \
		zip -FSr ../$(waitingcount_name) ./

$(membercount_target): $(membercount_source) $(membercount_source)
	@echo Creating membercount
	@rm -rf $(membercount_tmp)
	@mkdir -p $(membercount_tmp)
	@cp -r src/membercount/* $(membercount_tmp)
	@$(call replace_text,current_date,$(current_date),$(membercount_tmp)/mod_scoutmembercount.xml)
	@cd $(membercount_tmp) && \
		zip -FSr ../$(membercount_name) ./