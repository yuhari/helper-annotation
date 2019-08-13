## yuhari/annotation

### 介绍
> 1. 该扩展是基于`doctrine/annotation`的使用封装，帮助使用者更灵活、简单地使用`注释（annotation）`这一功能；
> 2. 支持`php7.2+`, 低版本的`php`可以适当修改语法也很容易完成兼容；

### 安装
```
composer require yuhari/annotation
```

### 使用示例
> `/demo` 下有使用示例，简单提供了三种常见的用法：

- Before Annotation 
 	> 定义在类创建、方法执行前的注释，比如可以用来收集日志、权限控制等； 
 	
- After Annotation  
	> 定义在类创建或方法执行后的注释，可以用来收集日志、与Before配合记录方法占有性能参数等；
	
- Bootstrap Annotation
	> 这种注释会在载入时获取分析，从而可以用来获取配置在类、方法注释中的配置，比如可以实现接口注释设置路由的功能；