-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 13, 2020 at 07:31 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `metubetest`
--

-- --------------------------------------------------------

--
-- Table structure for table `audiochannel`
--

CREATE TABLE `audiochannel` (
  `AChannel_ID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `ChannelName` varchar(256) NOT NULL,
  `SubscriptionCount` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `audiocommentreply`
--

CREATE TABLE `audiocommentreply` (
  `Audio_ID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `ACommentID` int(11) NOT NULL,
  `AReplyID` int(11) NOT NULL,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Likes` int(11) NOT NULL,
  `Description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `audiocommentsection`
--

CREATE TABLE `audiocommentsection` (
  `Audio_ID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `ACommentID` int(11) NOT NULL,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Likes` int(11) NOT NULL,
  `Description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `audiolist`
--

CREATE TABLE `audiolist` (
  `Audio_ID` int(11) NOT NULL,
  `AChannel_ID` int(11) NOT NULL,
  `AudioName` varchar(256) NOT NULL,
  `Path` varchar(256) NOT NULL,
  `Size` int(11) NOT NULL,
  `Format` int(11) NOT NULL,
  `AccessType` varchar(20) NOT NULL,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Views` int(11) NOT NULL,
  `Likes` int(11) NOT NULL,
  `Dislikes` int(11) NOT NULL,
  `Description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `audioplaylist`
--

CREATE TABLE `audioplaylist` (
  `PlaylistID` int(11) NOT NULL,
  `audio_id` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Playlist_name` varchar(256) NOT NULL,
  `AccessType` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `audiosubscriptions`
--

CREATE TABLE `audiosubscriptions` (
  `UserID` int(11) NOT NULL,
  `AChannel_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `audiotags`
--

CREATE TABLE `audiotags` (
  `audio_ID` int(11) NOT NULL,
  `tag` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `blocklist`
--

CREATE TABLE `blocklist` (
  `O_UserID` int(11) NOT NULL,
  `B_UserID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `contactlist`
--

CREATE TABLE `contactlist` (
  `O_UserID` int(11) NOT NULL,
  `C_UserID` int(11) NOT NULL,
  `type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `forum`
--

CREATE TABLE `forum` (
  `ForumID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Description` text NOT NULL,
  `AccessType` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `imagelist`
--

CREATE TABLE `imagelist` (
  `Image_ID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `ImageName` int(11) NOT NULL,
  `ImagePath` varchar(256) NOT NULL,
  `Size` int(11) NOT NULL,
  `Format` varchar(20) NOT NULL,
  `AccessType` varchar(20) NOT NULL,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `imagetags`
--

CREATE TABLE `imagetags` (
  `Image_ID` int(11) NOT NULL,
  `tag` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `PostID` int(11) NOT NULL,
  `ForumID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Upvotes` int(11) NOT NULL,
  `Description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `postreply`
--

CREATE TABLE `postreply` (
  `RPostID` int(11) NOT NULL,
  `PostID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Upvotes` int(11) NOT NULL,
  `Description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `email` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  `fname` varchar(100) DEFAULT NULL,
  `lname` int(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `videochannel`
--

CREATE TABLE `videochannel` (
  `VChannel_ID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `ChannelName` varchar(256) NOT NULL,
  `SubscriptionCount` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `videocommentreply`
--

CREATE TABLE `videocommentreply` (
  `Video_ID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `VCommentID` int(11) NOT NULL,
  `VReplyID` int(11) NOT NULL,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Likes` int(11) NOT NULL,
  `Description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `videocommentsection`
--

CREATE TABLE `videocommentsection` (
  `Video_ID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `VCommentID` int(11) NOT NULL,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Likes` int(11) NOT NULL,
  `Description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `videolist`
--

CREATE TABLE `videolist` (
  `Video_ID` int(11) NOT NULL,
  `VChannel_ID` int(11) NOT NULL,
  `VideoName` varchar(256) NOT NULL,
  `Path` varchar(256) NOT NULL,
  `Size` int(11) NOT NULL,
  `Format` varchar(30) NOT NULL,
  `AccessType` varchar(30) NOT NULL,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Views` int(11) NOT NULL,
  `Likes` int(11) NOT NULL,
  `Dislikes` int(11) NOT NULL,
  `Description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `videoplaylist`
--

CREATE TABLE `videoplaylist` (
  `PlaylistID` int(11) NOT NULL,
  `Video_ID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Playlist_Name` varchar(256) NOT NULL,
  `AccessType` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `videosubscriptions`
--

CREATE TABLE `videosubscriptions` (
  `UserID` int(11) NOT NULL,
  `VChannel_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `videotags`
--

CREATE TABLE `videotags` (
  `video_ID` int(11) NOT NULL,
  `tag` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audiochannel`
--
ALTER TABLE `audiochannel`
  ADD PRIMARY KEY (`AChannel_ID`),
  ADD KEY `fk_audiouser` (`UserID`);

--
-- Indexes for table `audiocommentreply`
--
ALTER TABLE `audiocommentreply`
  ADD PRIMARY KEY (`AReplyID`),
  ADD KEY `fk_audioreplyid` (`Audio_ID`),
  ADD KEY `fk_replyuser` (`UserID`),
  ADD KEY `fk_audiocommentreplyid` (`ACommentID`);

--
-- Indexes for table `audiocommentsection`
--
ALTER TABLE `audiocommentsection`
  ADD PRIMARY KEY (`ACommentID`),
  ADD KEY `fk_acommentuser` (`UserID`);

--
-- Indexes for table `audiolist`
--
ALTER TABLE `audiolist`
  ADD PRIMARY KEY (`Audio_ID`),
  ADD KEY `fk_audiochannel` (`AChannel_ID`);

--
-- Indexes for table `audioplaylist`
--
ALTER TABLE `audioplaylist`
  ADD KEY `fk_audioid` (`audio_id`),
  ADD KEY `fk_aplaylistuser` (`UserID`);

--
-- Indexes for table `audiosubscriptions`
--
ALTER TABLE `audiosubscriptions`
  ADD KEY `fk_ausubemail` (`AChannel_ID`),
  ADD KEY `fk_asubuser` (`UserID`);

--
-- Indexes for table `audiotags`
--
ALTER TABLE `audiotags`
  ADD KEY `fk_audiotag` (`audio_ID`);

--
-- Indexes for table `blocklist`
--
ALTER TABLE `blocklist`
  ADD KEY `fk_ouser` (`O_UserID`),
  ADD KEY `fk_Buser` (`B_UserID`);

--
-- Indexes for table `contactlist`
--
ALTER TABLE `contactlist`
  ADD KEY `fk_COuser` (`O_UserID`),
  ADD KEY `fk_CCuser` (`C_UserID`);

--
-- Indexes for table `forum`
--
ALTER TABLE `forum`
  ADD PRIMARY KEY (`ForumID`),
  ADD KEY `fk_forumuser` (`UserID`);

--
-- Indexes for table `imagelist`
--
ALTER TABLE `imagelist`
  ADD PRIMARY KEY (`Image_ID`),
  ADD KEY `fk_imageuser` (`UserID`);

--
-- Indexes for table `imagetags`
--
ALTER TABLE `imagetags`
  ADD KEY `fk_imagetag` (`Image_ID`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`PostID`),
  ADD KEY `fk_postforum` (`ForumID`),
  ADD KEY `fk_postuser` (`UserID`);

--
-- Indexes for table `postreply`
--
ALTER TABLE `postreply`
  ADD PRIMARY KEY (`RPostID`),
  ADD KEY `fk_replypost` (`PostID`),
  ADD KEY `fk_postreplyuser` (`UserID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `videochannel`
--
ALTER TABLE `videochannel`
  ADD PRIMARY KEY (`VChannel_ID`),
  ADD KEY `fk_channeluser` (`UserID`);

--
-- Indexes for table `videocommentreply`
--
ALTER TABLE `videocommentreply`
  ADD PRIMARY KEY (`VReplyID`),
  ADD KEY `fk_videereplyid` (`Video_ID`),
  ADD KEY `fk_vsubuser` (`UserID`),
  ADD KEY `fk_videocommentreplyid` (`VCommentID`);

--
-- Indexes for table `videocommentsection`
--
ALTER TABLE `videocommentsection`
  ADD PRIMARY KEY (`VCommentID`),
  ADD KEY `fk_videocommentid` (`Video_ID`),
  ADD KEY `fk_videocomment` (`UserID`);

--
-- Indexes for table `videolist`
--
ALTER TABLE `videolist`
  ADD PRIMARY KEY (`Video_ID`),
  ADD KEY `fk_videochannel` (`VChannel_ID`);

--
-- Indexes for table `videoplaylist`
--
ALTER TABLE `videoplaylist`
  ADD KEY `fk_playlistvideoid` (`Video_ID`),
  ADD KEY `fk_vplaylistuser` (`UserID`);

--
-- Indexes for table `videosubscriptions`
--
ALTER TABLE `videosubscriptions`
  ADD KEY `fk_videochannelid` (`VChannel_ID`);

--
-- Indexes for table `videotags`
--
ALTER TABLE `videotags`
  ADD KEY `fk_videotag` (`video_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audiochannel`
--
ALTER TABLE `audiochannel`
  MODIFY `AChannel_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `audiocommentreply`
--
ALTER TABLE `audiocommentreply`
  MODIFY `AReplyID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `audiocommentsection`
--
ALTER TABLE `audiocommentsection`
  MODIFY `ACommentID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `audiolist`
--
ALTER TABLE `audiolist`
  MODIFY `Audio_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `forum`
--
ALTER TABLE `forum`
  MODIFY `ForumID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `imagelist`
--
ALTER TABLE `imagelist`
  MODIFY `Image_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `PostID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `postreply`
--
ALTER TABLE `postreply`
  MODIFY `RPostID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `videochannel`
--
ALTER TABLE `videochannel`
  MODIFY `VChannel_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `videocommentreply`
--
ALTER TABLE `videocommentreply`
  MODIFY `VReplyID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `videocommentsection`
--
ALTER TABLE `videocommentsection`
  MODIFY `VCommentID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `videolist`
--
ALTER TABLE `videolist`
  MODIFY `Video_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `audiochannel`
--
ALTER TABLE `audiochannel`
  ADD CONSTRAINT `fk_audiouser` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `audiocommentreply`
--
ALTER TABLE `audiocommentreply`
  ADD CONSTRAINT `fk_audiocommentreplyid` FOREIGN KEY (`ACommentID`) REFERENCES `audiocommentsection` (`ACommentID`),
  ADD CONSTRAINT `fk_audioreplyid` FOREIGN KEY (`Audio_ID`) REFERENCES `audiolist` (`Audio_ID`),
  ADD CONSTRAINT `fk_replyuser` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `audiocommentsection`
--
ALTER TABLE `audiocommentsection`
  ADD CONSTRAINT `fk_acommentuser` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `audiolist`
--
ALTER TABLE `audiolist`
  ADD CONSTRAINT `fk_audiochannel` FOREIGN KEY (`AChannel_ID`) REFERENCES `audiochannel` (`AChannel_ID`);

--
-- Constraints for table `audioplaylist`
--
ALTER TABLE `audioplaylist`
  ADD CONSTRAINT `fk_aplaylistuser` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `fk_audioid` FOREIGN KEY (`audio_id`) REFERENCES `audiolist` (`Audio_ID`),
  ADD CONSTRAINT `fk_playlistaudioid` FOREIGN KEY (`audio_id`) REFERENCES `audiolist` (`Audio_ID`);

--
-- Constraints for table `audiosubscriptions`
--
ALTER TABLE `audiosubscriptions`
  ADD CONSTRAINT `fk_asubuser` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `fk_ausubemail` FOREIGN KEY (`AChannel_ID`) REFERENCES `audiochannel` (`AChannel_ID`);

--
-- Constraints for table `audiotags`
--
ALTER TABLE `audiotags`
  ADD CONSTRAINT `fk_audiotag` FOREIGN KEY (`audio_ID`) REFERENCES `audiolist` (`Audio_ID`);

--
-- Constraints for table `blocklist`
--
ALTER TABLE `blocklist`
  ADD CONSTRAINT `fk_Buser` FOREIGN KEY (`B_UserID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `fk_ouser` FOREIGN KEY (`O_UserID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `contactlist`
--
ALTER TABLE `contactlist`
  ADD CONSTRAINT `fk_CCuser` FOREIGN KEY (`C_UserID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `fk_COuser` FOREIGN KEY (`O_UserID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `forum`
--
ALTER TABLE `forum`
  ADD CONSTRAINT `fk_forumuser` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `imagelist`
--
ALTER TABLE `imagelist`
  ADD CONSTRAINT `fk_imageuser` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `imagetags`
--
ALTER TABLE `imagetags`
  ADD CONSTRAINT `fk_imagetag` FOREIGN KEY (`Image_ID`) REFERENCES `imagelist` (`Image_ID`);

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `fk_postforum` FOREIGN KEY (`ForumID`) REFERENCES `forum` (`ForumID`),
  ADD CONSTRAINT `fk_postuser` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `postreply`
--
ALTER TABLE `postreply`
  ADD CONSTRAINT `fk_postreplyuser` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `fk_replypost` FOREIGN KEY (`PostID`) REFERENCES `post` (`PostID`);

--
-- Constraints for table `videochannel`
--
ALTER TABLE `videochannel`
  ADD CONSTRAINT `fk_channeluser` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `videocommentreply`
--
ALTER TABLE `videocommentreply`
  ADD CONSTRAINT `fk_videereplyid` FOREIGN KEY (`Video_ID`) REFERENCES `videolist` (`Video_ID`),
  ADD CONSTRAINT `fk_videocommentreplyid` FOREIGN KEY (`VCommentID`) REFERENCES `videocommentsection` (`VCommentID`),
  ADD CONSTRAINT `fk_videoreplyuser` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `fk_vsubuser` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `videocommentsection`
--
ALTER TABLE `videocommentsection`
  ADD CONSTRAINT `fk_videocomment` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `fk_videocommentid` FOREIGN KEY (`Video_ID`) REFERENCES `videolist` (`Video_ID`);

--
-- Constraints for table `videolist`
--
ALTER TABLE `videolist`
  ADD CONSTRAINT `fk_videochannel` FOREIGN KEY (`VChannel_ID`) REFERENCES `videochannel` (`VChannel_ID`);

--
-- Constraints for table `videoplaylist`
--
ALTER TABLE `videoplaylist`
  ADD CONSTRAINT `fk_playlistvideoid` FOREIGN KEY (`Video_ID`) REFERENCES `videolist` (`Video_ID`),
  ADD CONSTRAINT `fk_vplaylistuser` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `videosubscriptions`
--
ALTER TABLE `videosubscriptions`
  ADD CONSTRAINT `fk_videochannelid` FOREIGN KEY (`VChannel_ID`) REFERENCES `videochannel` (`VChannel_ID`);

--
-- Constraints for table `videotags`
--
ALTER TABLE `videotags`
  ADD CONSTRAINT `fk_videotag` FOREIGN KEY (`video_ID`) REFERENCES `videolist` (`Video_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
