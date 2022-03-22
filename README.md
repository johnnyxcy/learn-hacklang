# learn-hacklang

这个 repo 用来记录我在学习 hack 的过程中遇到的坑以及一些 entry level 的项目实现

## M1 Mac 安装 HHVM

HHVM 目前并不支持 M1 Mac (see [this issue](https://github.com/facebook/hhvm/issues/8875))，必须要在 x86_64 (x64，amd64 同平台) 平台上开发才能够正确 build HHVM

所以可以通过在官方支持的 x86_64 Linux 下构建 HHVM 环境再通过 ssh 跳板开发

### 坑1 - 没有 x86_64 Linux 开发环境

如果你没有一个 x86_64 Linux 的开发机，或者你的开发机像我一样正好无法正常启动，那么最简单的办法就是在 x86_64 的 windows 下通过 WSL 挂载 Ubuntu 进行开发

### 坑2 - WSL 虚拟机问题

Q: 在 WSL 中按照 [HHVM 官网](https://docs.hhvm.com/hhvm/installation/linux) 安装了 HHVM 之后 尝试 `hhvm --version` 出现了 `Exec format error`

在顺利 `apt-get install hhvm` 之后无法正确执行 `hhvm` 的 binary 的原因普遍是 WSL1 对虚拟机的支持问题，建议升级 WSL2，具体见[这篇知乎](https://zhuanlan.zhihu.com/p/356397851)

### 坑3 - SSH 跳板问题

Q：现在 WSL 中的 hhvm 开发环境配置完成了，需要提供 ssh 登陆的手段

1. 首先需要在 WSL 中配置 ssh server

    `sudo vi /etc/ssh/sshd_config`

    Port `${SSH_PORT}` 指定 WSL 的 ssh 端口号
    PermitRootLogin yes
    PasswordAuthentication yes

2. 然后配置支持的 host

    `sudo vim /etc/hosts.allow`

    添加 sshd: ALL

3. 重启 ssh

    `sudo service ssh --full-restart`

4. 检查服务是否正常启动

    `service --status-all`

    看到 

    ```
    ...
    [ + ]  ssh
    ...
    ```

    说明 ok 了

5. 配置端口转发

    在 Windows 下管理员启动终端并输入

    ```
    netsh interface portproxy add v4tov4 listenaddress=0.0.0.0 listenport=${WINDOWS_PORT} connectaddress=localhost connectport=${SSH_PORT}
    ```

    其中 `${SSH_PORT}` 是上面设置的 WSL ssh 端口号，`${WINDOWS_PORT}` 是作为跳板的 Windows 监听请求的端口号

6. 检查端口转发

    ```
    netsh interface portproxy show all
    ```

    结果类似下面即可

    ```
    Address      Port                 Address      Port       
    ------------ -------------------- ------------ --------------------
    0.0.0.0      ${WINDOWS_PORT}      localhost    ${SSH_PORT}
    ```

7. 设置防火墙

    正确设置 Windows 防火墙，开放 `${WINDOWS_PORT}` 端口，不做赘述

8. 获取 windows 局域网 ip

    ```
    ipconfig
    ```

9. 然后就可以通过 ssh 登陆了

    ```
    ssh ${WSL_USR_NAME}@${WINDOWS_IP} -p ${WINDOWS_PORT}
    ```

### 坑4 - SSH 登陆失败 `kex_exchange_identification: Connection closed by remote host`

有多个原因

1. 并发异常

- 通过修改 `/etc/ssh/sshd_config` 中的 `MaxSessions` 和 `MaxStartups` 解决，改大点

2. 端口异常

- 如果 `${WINDOWS_PORT}` 和 `${SSH_PORT}` 端口号一样的话也会出现这个问题，建议设为不同的端口号防止访问冲突
